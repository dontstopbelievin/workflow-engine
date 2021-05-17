<script src="https://js.arcgis.com/4.18/"></script>
<script>

  var to_add_graphic = null;
  var objectId = null;
  var land_layer = null;
  var query_layer = null;
  var g_layer = null;

  document.addEventListener("DOMContentLoaded", () => {
    arcgis_login()
  });

  const load_layer = () => {
    require([
      "esri/layers/FeatureLayer",
      "esri/layers/TileLayer",
      "esri/widgets/Sketch",
      "esri/tasks/GeometryService",
      "esri/tasks/support/AreasAndLengthsParameters",
      "esri/config",
      "esri/Map",
      "esri/views/MapView",
      "esri/layers/GraphicsLayer",
      "esri/widgets/Fullscreen",
    ], function(FeatureLayer, TileLayer, Sketch, GeometryService, AreasAndLengthsParameters, esriConfig,Map, MapView, GraphicsLayer, Fullscreen) {
      esriConfig.portalUrl = "https://gis.esaulet.kz/arcgis";
      g_layer = new GraphicsLayer({});
      query_layer = new GraphicsLayer({});

      let layers = [];
      let t_layer = new TileLayer({
        url: "https://gis.esaulet.kz/server/rest/services/Hosted/1_20/MapServer"
      });
      layers.push(t_layer);
      for (var i = 1; i <= 9; i++) {
        let t_layer = new TileLayer({
          url: "https://gis.esaulet.kz/server/rest/services/Hosted/"+i+"/MapServer"
        });
        layers.push(t_layer);
      }

      window.map = new Map({ layers: layers});

      window.view = new MapView({
          container: "viewDiv",
          map: window.map,
          center: [71.423, 51.148],
          ui: {
              components: []
          },
          scale: 100000
      })

      window.map.add(g_layer)
      window.map.add(query_layer)

      let fullscreen = new Fullscreen({
        view: window.view
      });
      window.view.ui.add(fullscreen, "top-right");

      let geometryService = new GeometryService({
        url: 'https://sampleserver6.arcgisonline.com/arcgis/rest/services/Utilities/Geometry/GeometryServer'});
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
        window.view.ui.add([{
          component: "zoom",
          position: "top-left",
        }])

        sketch.on("create", function(event) {
          if (event.state === "start") {
            g_layer.graphics.removeAll()
          }
          if (event.state === "complete") {
            console.log('complete');

            const attributes = {};
            attributes["name"] = "{{auth()->user()->email ?? 'guest'}}";

            let new_item = event.graphic;
            new_item.attributes = attributes
            to_add_graphic = new_item;
            geometryService.simplify([new_item.geometry]).then(function(simplifiedGeometries){
              var areasAndLengthParams = new AreasAndLengthsParameters({
                areaUnit: "hectares",
                lengthUnit: "kilometers",
                polygons: simplifiedGeometries
              });
              geometryService.areasAndLengths(areasAndLengthParams).then(function(results){
                document.getElementById('area').value = results.areas[0];
                console.log("area: ", results.areas[0]);
                console.log("length: ", results.lengths[0]);
              });
            });
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
    if(document.getElementById('area')){
      to_add_graphic.attributes['area'] = document.getElementById('area').value;
    }
    if(document.getElementById('object_address')){
      to_add_graphic.attributes['adr_zem'] = document.getElementById('object_address').value;
    }
    
    land_layer
      .applyEdits({addFeatures: [to_add_graphic]})
      .then(function(result) {
        if (result.addFeatureResults.length > 0) {
          objectId = result.addFeatureResults[0].objectId;
          document.getElementById('object_id').value = objectId
          create_applic()
          console.log(objectId)
        }else{
          alert('Ошибка авторизации на карте')
        }
        queryLayer().then(displayResults);
        // console.log(result)
      })
      .catch(function(error) {
        alert('Ошибка авторизации на карте')
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
        alert('Ошибка авторизации на карте')
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
        let label = fields[i].alias
        if(fields[i].alias.split('.')[0] == 'db_2dqxx'){
          label = fields[i].alias.split('.').pop()
        }
        if(fields[i].name == 'objectid' || fields[i].name == 'SHAPE__Length' || fields[i].name == 'SHAPE__Area'
          || fields[i].name == 'created_user' || fields[i].name == 'created_date' ||
          fields[i].name == 'last_edited_user' || fields[i].name == 'last_edited_date' || fields[i].name == 'globalid'){
          continue;
        }
        if(i%2){
            temp += '<tr style="background-color: rgba(0, 0, 255, 0.05);">'
            temp += '<td class="attrName">'+label+':</td>  <td class="attrValue">{'+fields[i].name+'}</td></tr>'
        }else{
            temp += '<tr style="background-color: rgba(0, 255, 0, 0.05);">'
            temp += '<td class="attrName">'+label+':</td>  <td class="attrValue">{'+fields[i].name+'}</td></tr>'
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