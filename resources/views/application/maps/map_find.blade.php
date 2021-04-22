<script src="https://js.arcgis.com/4.18/"></script>
<script>

  var to_add_graphic = null;
  var objectId = null;

  var land_layer = null;
  var query_layer = null;
  var g_layer = null;
  var oldPoint = [];
  var layer_url = "https://services5.arcgis.com/F4L2sw7TTOlSm1OJ/arcgis/rest/services/Слои_по_карте_земельных_отношений/FeatureServer"
  var layer_id = 7

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

  const find_kadastr = () => {
    queryKad().then(displayResults);
    return;
    require([
    "esri/Graphic",
    "esri/tasks/FindTask",
    "esri/tasks/support/FindParameters",
    ], function(Graphic, FindTask, FindParameters) {
      let kadastr_number = document.getElementById("cadastr_number").value;
      console.log(kadastr_number)
      var find = new FindTask({
        url: "https://gis.esaulet.kz/server/rest/services/Hosted/Административные_объекты_14042021/FeatureServer"
      })
      var params = new FindParameters({
        layerIds: [9],
        searchFields: ['kad_nomer', 'fulladdress'],
        returnGeometry: true
      })
      params.searchText = kadastr_number.trim();
      find.execute(params).then(showResults).catch(rejectedPromise);
      console.log('kadastr_number')
      function rejectedPromise(error) {
        console.error("Promise didn't resolve: ", error.message);
      }
      function showResults(response) {
        console.log(response)
        return response.results.map(function(result) {
          console.log(result.feature);
          switch (result.layerName) {
            case 'Земельные участки':
                // console.log(result.feature.attributes['Полный адрес'].trim());
                address = result.feature.attributes['Полный адрес'].trim();
                showPoint(result.feature.geometry.centroid.latitude, result.feature.geometry.centroid.longitude);
                break;
            default:
                console.log('Не найден');
                address = 'Не найден';
          }
          return address;
        });
      }
      function showPoint(latitude, longitude){
        window.view.center = [longitude.toFixed(5), latitude.toFixed(5)];
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

        window.view.graphics.remove(oldPoint);
        window.view.graphics.add(pointGraphic);

        oldPoint = pointGraphic;
      }
    });
  }

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
      'esri/widgets/Search',
    ], function(FeatureLayer, Sketch, Search) {
      // let url = 'https://gis.esaulet.kz/server/rest/services/Hosted/Пустой_слой/FeatureServer/0'
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
            searchFields: ["objectid"],
            displayField: "objectid",
            exactMatch: false,
            outFields: ["*"],
            name: "Поиск по адресу",
            placeholder: "Введите адрес",
            maxResults: 6,
            maxSuggestions: 6,
            enableSuggestions: true,
          }
        ]});
        window.view.ui.add(searchWidget, {
          position: "top-right"
        });
        searchWidget.on("search-complete", function(event){
          // The results are stored in the event Object[]
          console.log("Results of the search: ", event);
        });
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

  const queryLayer = (results) => {
    var query = land_layer.createQuery();
    query.where = "name = '{{auth()->user()->email ?? 'guest'}}'";
    // query.where = "fid = 36";
    return land_layer.queryFeatures(query)
  }

  const queryKad = (results) => {
    var query = land_layer.createQuery();
    query.where = "kad_nomer = '21318095233'";
    // query.where = "fid = 36";
    return land_layer.queryFeatures(query)
  }

  const displayResults = (results) => {
    query_layer.removeAll();
    console.log('displayResults')
    console.log(results)
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
</script>