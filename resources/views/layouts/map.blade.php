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
</style>
<div class="main-panel">
  	<div class="content">
	    <div class="container-fluid">
	      	<div class="card">
		        <div class="card-body" >
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
    ], function(esriConfig,Map, MapView, Graphic, GraphicsLayer, FeatureLayer, 
      Editor, LayerList, Sketch, GraphicsLayer, Fullscreen) {

  var g_layer = new GraphicsLayer({});

  const add_layer = (url, check = false) => {
    let layer = new FeatureLayer({
        url: url,
    })
    existLayerReplace(layer)

    layer.when(() => {
      if(check){
        const sketch = new Sketch({
          layer: g_layer,
          view: window.view,
          creationMode: "update"
        });
        view.ui.add(sketch, "top-right");
        console.log('asdf')
        sketch.on("create", function(event) {
          // check if the create event's state has changed to complete indicating
          // the graphic create operation is completed.
          if (event.state === "complete") {
            // remove the graphic from the layer. Sketch adds
            // the completed graphic to the layer by default.
            // layer.remove(event.graphic);
            console.log('complete');

            // use the graphic.geometry to query features that intersect it
            // selectFeatures(event.graphic.geometry);
          }
        });
      }
      var template = {
          lastEditInfoEnabled: false,
          title: layer.name,
          content: get_fields(layer.fields)
      }
      layer.popupTemplate = template
      existLayerReplace(layer)
    });
  }

  esriConfig.portalUrl = "https://kazaero.maps.arcgis.com/arcgis";
  // esriConfig.portalUrl = "https://gis.esaulet.kz/arcgis";

  window.map = new Map({
      basemap: "streets" //Basemap layer service
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
  window.map.add(g_layer);
  // let url = 'https://gis.esaulet.kz/server/rest/services/Hosted/Пустой_слой/FeatureServer'
  let url = 'https://services5.arcgis.com/F4L2sw7TTOlSm1OJ/arcgis/rest/services/Слои_по_карте_земельных_отношений/FeatureServer'

  for (var i = 1; i < 7; i++){
    if(i == 1){
      add_layer(url+'/'+i, true)
    }else{
      add_layer(url+'/'+i)
    }
  }

  let fullscreen = new Fullscreen({
    view: window.view
  });
  window.view.ui.add(fullscreen, "top-left");
  window.view.when(function() {
    var layerList = new LayerList({
      view: window.view
    });
    window.view.ui.add(layerList, "top-right");
  });

  const editor = new Editor({
    view: window.view
  });
  window.view.ui.add(editor, "top-right");

 });
</script>
@append