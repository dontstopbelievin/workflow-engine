<script src="https://js.arcgis.com/4.18/"></script>
<script>

  var oldPoint = null
  var land_layer = null
  var query_layer = null
  @if($process->name == 'Предоставление земельного участка для строительства объекта в черте населенного пункта')
    var layer_url = "https://gis.esaulet.kz/server/rest/services/Hosted/Пустой_слой/FeatureServer"
    var layer_id = 0
    var layer_query_attr = "fid"
  @else
    var layer_url = "https://gis.esaulet.kz/server/rest/services/Hosted/Административные_объекты_14042021/FeatureServer"
    var layer_id = 9
    var layer_query_attr = "objectid"
  @endif
  var lyrView

  document.addEventListener("DOMContentLoaded", () => {
    arcgis_login()
  });

  const load_layer = () => {
    require([
      "esri/layers/FeatureLayer",
      "esri/layers/TileLayer",
      "esri/config",
      "esri/Map",
      "esri/views/MapView",
      "esri/layers/GraphicsLayer",
      "esri/widgets/Fullscreen",
    ], function(FeatureLayer, TileLayer, esriConfig, Map, MapView, GraphicsLayer, Fullscreen) {

      esriConfig.portalUrl = "https://gis.esaulet.kz/portal";
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
        highlightOptions: {
          color: [255,69,0],
          fillOpacity: 0.4
        },
        scale: 100000
      })

      window.map.add(query_layer)

      let url = layer_url+'/'+layer_id

      land_layer = new FeatureLayer({
        url: url,
        visible: true,
      })
      existLayerReplace(land_layer)

      window.view.whenLayerView(land_layer).then(function(layerView) {
        lyrView = layerView;
        queryLayer().then(displayResults)
      });

      land_layer.when(() => {
        var template = {
            lastEditInfoEnabled: false,
            title: land_layer.name,
            content: get_fields(land_layer.fields)
        }
        land_layer.popupTemplate = template
        existLayerReplace(land_layer)
        const show_object = document.createElement("button");
        show_object.className = "esri_btn_custom";
        show_object.innerHTML = "Показать объект";
        show_object.onclick = function () {
  		    queryLayer().then(displayResults)
  	    };
        view.ui.add(show_object,{
           position: "top-left"
        });
        window.view.ui.components=["zoom"];
      })

      let fullscreen = new Fullscreen({
        view: window.view
      });
      window.view.ui.add(fullscreen, "top-right");
    })
  }

  const find_kadastr = () => {
    queryLayer().then(displayResults);
  }

  const queryLayer = (results) => {
    var query = land_layer.createQuery();
    let objectid = document.getElementById('object_id').innerHTML.trim()
    query.where = layer_query_attr+" = '"+objectid+"'";
    return land_layer.queryFeatures(query)
  }

  const displayResults = (results) => {
    query_layer.removeAll();
    console.log('displayResults')
    console.log(results)
    if(results.features[0]){
	  lyrView.highlight(results.features[0]);
      let longitude = results.features[0].geometry.centroid.longitude
      let latitude = results.features[0].geometry.centroid.latitude
      window.view.center = [longitude.toFixed(5), latitude.toFixed(5)];
      window.view.scale = 3000;
    }
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
          alert('Ошибка авторизации к карте')
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