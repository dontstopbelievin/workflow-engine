<script src="https://js.arcgis.com/4.18/"></script>
<script>

  var to_add_graphic = null;
  var objectId = null;

  var land_layer = null;
  var query_layer = null;
  var g_layer = null;

  require([
    "esri/config",
    "esri/Map",
    "esri/views/MapView",
    "esri/layers/GraphicsLayer",
    "esri/widgets/LayerList",
    "esri/widgets/Fullscreen",
    "esri/identity/IdentityManager",
    ], function(esriConfig,Map, MapView, GraphicsLayer, 
      LayerList, Fullscreen, IdentityManager) {

  esriConfig.portalUrl = "https://gis.esaulet.kz/arcgis";
  g_layer = new GraphicsLayer({});
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

  const load_layer = () => {
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
    require([
      "esri/layers/FeatureLayer",
      "esri/widgets/Sketch",
    ], function(FeatureLayer, Sketch) {
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
        })
      })
    })
  }

  const register_token = (data) => {
    require([
    "esri/identity/IdentityManager"
    ], function(IdentityManager) {
      IdentityManager.registerToken({
        "userId": data.user,
        "token": data.token,
        "server": "https://gis.esaulet.kz/portal/sharing/rest",
        "expires": data.expires,
        "ssl": data.ssl,
      })
    })
  }

  const arcgis_login = () => {
    var xhr = new XMLHttpRequest();
    xhr.open("get", "{{url('get_token')}}", false);
    xhr.setRequestHeader("Authorization", "Bearer " + "{{csrf_token()}}");
    xhr.onload = function () {
      if(xhr.status == 200){
        let res = JSON.parse(xhr.responseText)
        if("error" in res){
          console.log('error')
          console.log(res)
          alert('Ошибка авторизации')
        }else{
          console.log('success')
          register_token(res)
          load_layer()
        }
      }else{
        console.log('error')
        console.log(xhr.responseText)
        alert('Ошибка авторизации')
      }
    }.bind(this)
    xhr.send();
  }

  const queryLayer = (results) => {
    var query = land_layer.createQuery();
    query.where = "name = '{{auth()->user()->email ?? 'guest'}}'";
    // query.where = "fid = 36";
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
            check_login(insert_item, window.map.layers.items[i])
        }
    }
  }

  const insert_item = (land_layer) => {
    console.log(to_add_graphic);
    land_layer
      .applyEdits({addFeatures: [to_add_graphic]})
      .then(function(result) {
        if (result.addFeatureResults.length > 0) {
          objectId = result.addFeatureResults[0].objectId;
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

  const check_login = (callback, layer) => {
    require([
    "esri/identity/IdentityManager"
    ], function(IdentityManager) {
      IdentityManager
      .checkSignInStatus("https://gis.esaulet.kz/portal/sharing")
      .then(function() {
        console.log("success login")
        callback(layer)
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