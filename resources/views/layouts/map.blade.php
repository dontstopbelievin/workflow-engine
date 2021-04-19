@extends('layouts.app')

@section('title')
    Входящие
@endsection

@section('content')
<link rel="stylesheet" href="https://js.arcgis.com/4.18/esri/css/main.css">
<style type="text/css">
.main-panel, .content{
	height: 100%!important;
}
.container-fluid, .card, .card-body {
  	padding: 0;
  	margin: 0;
  	height: 100%!important;
}
#viewDiv{
	padding: 0;
  	margin: 0;
  	height: 100%!important;
  	width: 100%;
}
.esri-component.esri-editor{
  width: 400px!important;
}
</style>
<div class="main-panel">
	<div class="content">
    <div class="container-fluid">
    	<div class="card">
        <div class="card-body" >
          <button class="btn btn-primary" onclick="add_land()" style="margin:10px;">Добавить</button>
					<div id="viewDiv"></div>
			  </div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script src="https://js.arcgis.com/4.18/"></script>
<script>

  var to_add_graphic = null;
  var land_layer = null;
  var query_layer = null;

  require([
    "esri/config",
    "esri/Map",
    "esri/views/MapView",
    "esri/Graphic",
    "esri/layers/GraphicsLayer",
    'esri/layers/FeatureLayer',
    "esri/widgets/Editor",
    "esri/widgets/LayerList",
    "esri/widgets/Sketch",
    "esri/layers/GraphicsLayer",
    "esri/widgets/Fullscreen",
    "esri/identity/IdentityManager",
    "esri/identity/ServerInfo",
    "esri/identity/Credential",
    "esri/identity/OAuthInfo",
    ], function(esriConfig,Map, MapView, Graphic, GraphicsLayer, FeatureLayer, 
      Editor, LayerList, Sketch, GraphicsLayer, Fullscreen, IdentityManager,
      ServerInfo, Credential, OAuthInfo) {

  esriConfig.portalUrl = "https://gis.esaulet.kz/arcgis";
  var g_layer = new GraphicsLayer({});
  query_layer = new GraphicsLayer({});

  window.map = new Map({
      basemap: "streets"
  });

  window.view = new MapView({
      container: "viewDiv",
      map: window.map,
      center: [71.423, 51.148],
      ui: {
          components: [ "attribution" ]
      },
      scale: 100000
  })

  window.map.add(g_layer)
  window.map.add(query_layer)

  arcgis_login()

  function load_layer(){
    // // let url = 'https://services5.arcgis.com/F4L2sw7TTOlSm1OJ/arcgis/rest/services/Слои_по_карте_земельных_отношений/FeatureServer'
    // for (var i = 0; i < 1; i++){
    //     add_layer(url+'/'+i)
    // }
    // const add_layer = (url) => {
    //   let layer = new FeatureLayer({
    //       url: url,
    //   })
    //   existLayerReplace(layer)
    //   layer.when(() => {
    //     var template = {
    //         lastEditInfoEnabled: false,
    //         title: layer.name,
    //         content: get_fields(layer.fields)
    //     }
    //     layer.popupTemplate = template
    //     existLayerReplace(layer)
    //   });
    // }
    check_login()
    let url = 'https://gis.esaulet.kz/server/rest/services/Hosted/Пустой_слой/FeatureServer/0'
    land_layer = new FeatureLayer({
      url: url,
      visible: false,
    })
    existLayerReplace(land_layer)

    land_layer.when(() => {
      queryLayer().then(displayResults)

      const sketch = new Sketch({
        layer: g_layer,
        view: window.view,
        creationMode: "update",
        availableCreateTools: ["polygon"],
      });
      window.view.ui.add(sketch, "top-left")

      sketch.on("create", function(event) {
        if (event.state === "start") {
          g_layer.graphics.removeAll()
        }
        if (event.state === "complete") {
          console.log('complete');

          const attributes = {};
          attributes["name"] = "{{auth()->user()->email ?? 'guest'}}";
          attributes["adr_zem"] = "380 New York St";

          let new_item = event.graphic;
          new_item.attributes = attributes
          to_add_graphic = new_item;
        }
      });
    });
  }

  function arcgis_login(){
    var xhr = new XMLHttpRequest();
    xhr.open("get", "{{url('get_token')}}", false);
    xhr.setRequestHeader("Authorization", "Bearer " + "{{csrf_token()}}");
    xhr.onload = function () {
      if(xhr.status == 200){
        let res = JSON.parse(xhr.responseText)
        if("error" in res){
          console.log('error')
          console.log(res)
        }else{
          console.log('success')
          register_token(res)
          load_layer()
        }
      }else{
        console.log('error')
        console.log(xhr.responseText)
      }
    }.bind(this)
    xhr.send();
  }

  function register_token(data){
    IdentityManager.registerToken({
      "userId": data.user,
      "token": data.token,
      "server": "https://gis.esaulet.kz/portal/sharing/rest",
      "expires": data.expires,
      "ssl": data.ssl,
    });
  }

  let fullscreen = new Fullscreen({
    view: window.view
  });
  window.view.ui.add(fullscreen, "top-right");

  // window.view.when(function() {
  //   var layerList = new LayerList({
  //     view: window.view
  //   });
  //   window.view.ui.add(layerList, "top-right");
  // });
 });

  const queryLayer = (results) => {
    var query = land_layer.createQuery();
    query.where = "name = '{{auth()->user()->email ?? 'guest'}}'";
    return land_layer.queryFeatures(query)
  }

  const displayResults = (results) => {
    query_layer.removeAll();
    console.log('displayResults')
    // console.log(results)
    var template = {
      lastEditInfoEnabled: false,
      // title: 'Земли',
      content: get_fields(results.fields)
    }
    var features = results.features.map(function (graphic) {
      graphic.symbol = {
        type: "simple-fill",
        color: [227, 139, 79, 0.8],
        outline: {
          color: [255, 255, 255],
          width: 1
        }
      }
      graphic.popupTemplate = template
      return graphic;
    });
    query_layer.addMany(results.features);
  }

  const add_land = () => {
    let url = 'https://gis.esaulet.kz/server/rest/services/Hosted/Пустой_слой/FeatureServer'
    for(var i=0; i<window.map.layers.items.length; i++){
        if(window.map.layers.items[i]['layerId'] == 0 &&
            window.map.layers.items[i]['url'] == url){
            insert_item(window.map.layers.items[i]);
        }
    }
  }

  const insert_item = (land_layer) => {
    check_login()
    land_layer
      .applyEdits({addFeatures: [to_add_graphic]})
      .then(function(result) {
        if (result.addFeatureResults.length > 0) {
          const objectId = result.addFeatureResults[0].objectId;
          // console.log(objectId)
        }
        queryLayer().then(displayResults);
        // console.log(result)
      })
      .catch(function(error) {
        console.error("[ applyEdits ] FAILURE: ", error.code, error.name, error.message);
        console.log("error = ", error);
      });
  }

  const check_login = () => {
    require([
    "esri/identity/IdentityManager"
    ], function(IdentityManager) {
      IdentityManager
      .checkSignInStatus("https://gis.esaulet.kz/portal/sharing")
      .then(function() {
        console.log("success login")
      })
      .catch(function(){
        console.log("trying login")
        arcgis_login()
      });
    })
  }

  const get_fields = (fields) => {
      if(!fields){
          return ''
      }
      let temp = '<table style="width:100%">'
      for (var i = 0; i < fields.length; i++) {
          if(i%2){
              temp += '<tr style="background-color: rgba(0, 0, 255, 0.05);">'
              temp += '<td class="attrName">'+fields[i].alias+':</td>  <td class="attrValue">{'+fields[i].name+'}</td></tr>'
          }else{
              temp += '<tr style="background-color: rgba(0, 255, 0, 0.05);">'
              temp += '<td class="attrName">'+fields[i].alias+':</td>  <td class="attrValue">{'+fields[i].name+'}</td></tr>'
          }
      }
      return temp += '</table>'
  }

  const existLayerReplace = (layer) => {
      for(var i=0; i<window.map.layers.items.length; i++){
          if(window.map.layers.items[i]['layerId'] == layer.layerId &&
              window.map.layers.items[i]['url'] == layer.url){
              window.map.layers.items[i] = layer;
              return true
          }
      }
      window.map.add(layer)
      return false;
  }
</script>
@append