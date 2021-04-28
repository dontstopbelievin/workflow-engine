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
          components: []
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

        const w_cont = document.createElement("div");
        w_cont.id = "w_cont";
        w_cont.style.width = "600px";
        w_cont.style.boxShadow = "none"
        window.view.ui.add(w_cont,{
           position: "top-left",
           index:0,
        });
        const wid_1 = document.createElement("div");
        wid_1.id = "wid_1";
        wid_1.style.display = "inline-block";
        wid_1.style.verticalAlign = "top";
        const wid_2 = document.createElement("div");
        wid_2.style.display = "inline-block";
        wid_2.id = "wid_2";
        wid_2.style.verticalAlign = "top";
        wid_2.style.marginLeft = "15px";
        document.getElementById('w_cont').appendChild(wid_1);
        document.getElementById('w_cont').appendChild(wid_2);

        var searchWidget = new Search({
        view: window.view,
        container: "wid_1",
        includeDefaultSources: false,
        allPlaceholder: "Найти по кадастру или адресу",
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
          // console.log("Results of the search: ", event);
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
        // window.view.ui.add(searchWidget, {
        //   position: "top-left",
        //   index: 0,
        // });
        const save_object = document.createElement("button");
        save_object.className = "esri_btn_custom float-left";
        save_object.innerHTML = "Выбрать объект";
        save_object.style.height = "32px";
        save_object.style.padding = "0px 10px";
        save_object.onclick = function () {
            save_point()
        };
        document.getElementById('wid_2').appendChild(save_object);
        // window.view.ui.add(save_object,{
        //    position: "top-left",
        //    index:2,
        // });
        window.view.ui.add([{
          component: "zoom",
          position: "top-left",
          index: 1
        }])
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
    if(document.getElementById('ulica_mestop_z_u'))
    document.getElementById('ulica_mestop_z_u').value = z_address
    if(document.getElementById('object_address'))
      document.getElementById('object_address').value = z_address
    if(document.getElementById('pravo_ru'))
      document.getElementById('pravo_ru').value = z_policy
    if(document.getElementById('object_name'))
      document.getElementById('object_name').value = z_name
    if(document.getElementById('cadastral_number'))
      document.getElementById('cadastral_number').value = z_kad_nomer
    if(document.getElementById('object_id'))
      document.getElementById('object_id').value = z_objectid

    // document.getElementById('viewDiv').style.height = '0px';
    // document.getElementById('s_h_but').innerHTML = 'Показать карту';
    // document.getElementById('s_point').style.display = 'none';
  }
</script>