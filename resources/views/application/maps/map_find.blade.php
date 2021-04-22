<script src="https://js.arcgis.com/4.18/"></script>
<script>

  var z_objectid = null
  var z_address = null
  var z_purpose = null
  var z_area = null
  var z_category = null
  var z_kad_nomer = null
  var z_name = null
  var z_policy = null
  var land_layer = null
  var query_layer = null
  var oldPoint = []
  var layer_url = "https://gis.esaulet.kz/server/rest/services/Hosted/Административные_объекты_14042021/FeatureServer"
  var layer_id = 9

  require([
    "esri/config",
    "esri/Map",
    "esri/views/MapView",
    "esri/layers/GraphicsLayer",
    "esri/widgets/LayerList",
    "esri/widgets/Fullscreen",
    "esri/identity/IdentityManager",
    ], function(esriConfig, Map, MapView, GraphicsLayer, 
      LayerList, Fullscreen, IdentityManager) {

  esriConfig.portalUrl = "https://gis.esaulet.kz/portal";
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

  window.map.add(query_layer)

  arcgis_login()

  let fullscreen = new Fullscreen({
    view: window.view
  });
  window.view.ui.add(fullscreen, "top-right");
 });

  const find_kadastr = () => {
    queryLayer().then(displayResults);
  }

  const load_layer = () => {
    require([
      "esri/layers/FeatureLayer",
      "esri/widgets/Sketch",
      'esri/widgets/Search',
    ], function(FeatureLayer, Sketch, Search) {
      let url = layer_url+'/'+layer_id

      land_layer = new FeatureLayer({
        url: url,
        visible: true,
      })
      existLayerReplace(land_layer)

      land_layer.when(() => {
        var template = {
            lastEditInfoEnabled: false,
            title: land_layer.name,
            content: get_fields(land_layer.fields)
        }
        land_layer.popupTemplate = template
        existLayerReplace(land_layer)

        var searchWidget = new Search({
        view: window.view,
        includeDefaultSources: false,
        sources: [{
            layer: land_layer,
            searchFields: ["kad_nomer"],
            displayField: "kad_nomer",
            exactMatch: false,
            outFields: ["*"],
            name: "Кадастровый номер",
            placeholder: "Введите кадастровый номер",
            maxResults: 6,
            maxSuggestions: 6,
            enableSuggestions: true,
          },
          {
            layer: land_layer,
            searchFields: ["fulladdress"],
            displayField: "fulladdress",
            exactMatch: false,
            outFields: ["*"],
            name: "Поиск по адресу",
            placeholder: "Введите адрес",
            maxResults: 6,
            maxSuggestions: 6,
            enableSuggestions: true,
          }
        ]});
        searchWidget.on("search-complete", function(event){
          // The results are stored in the event Object[]
          console.log("Results of the search: ", event);
          if(event.results[0] && event.results[0].results[0]){
            let res = event.results[0].results[0].feature.attributes
            z_objectid = res.objectid
            z_address = res.fulladdress
            z_purpose = res.purpose
            z_area = res.areasquare

            z_category = res.category
            z_kad_nomer = res.kad_nomer
            z_name = res.name
            z_policy = res.policy
          }
        });
        window.view.ui.add(searchWidget, {
          position: "top-left"
        });
      })
    })
  }

  const queryLayer = (results) => {
    var query = land_layer.createQuery();
    query.where = "kad_nomer = '21318095233'";
    return land_layer.queryFeatures(query)
  }

  const displayResults = (results) => {
    query_layer.removeAll();
    console.log('displayResults')
    // console.log(results)
    if(results.features[0]){
      let longitude = results.features[0].geometry.centroid.longitude
      let latitude = results.features[0].geometry.centroid.latitude
      showPoint(latitude, longitude)
    }
  }

  const showPoint = (latitude, longitude) => {
    require([
    "esri/Graphic"
    ], function(Graphic) {
      window.view.center = [longitude.toFixed(5), latitude.toFixed(5)];
      window.view.scale = 10000;
      // document.getElementById("objectId").innerHTML = '';

      var point = {
        type: "point",
        longitude: longitude.toFixed(5),
        latitude: latitude.toFixed(5)
      };

      var markerSymbol = {
        type: "simple-marker",
        color: [226, 119, 40],
        outline: {
          color: [255, 255, 255],
          width: 2
        }
      };

      var pointGraphic = new Graphic({
        geometry: point,
        symbol: markerSymbol
      });

      query_layer.remove(oldPoint);
      query_layer.add(pointGraphic);

      oldPoint = pointGraphic;
    });
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
          if(fields[i].name == 'objectid' || fields[i].name == 'SHAPE__Length' ||
            fields[i].name == 'created_user' || fields[i].name == 'created_date' ||
            fields[i].name == 'last_edited_user' || fields[i].name == 'last_edited_date' || fields[i].name == 'globalid'){
            continue;
          }
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

  const save_point = () => {
    document.getElementById('ulica_mestop_z_u').value = z_address

    document.getElementById('viewDiv').style.height = '0px';
    document.getElementById('s_h_but').innerHTML = 'Показать карту';
    document.getElementById('s_point').style.display = 'none';
  }
</script>