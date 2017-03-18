webpackJsonp([1,2],{

/***/ 10:
/***/ (function(module, exports) {

module.exports = function normalizeComponent (
  rawScriptExports,
  compiledTemplate,
  scopeId,
  cssModules
) {
  var esModule
  var scriptExports = rawScriptExports = rawScriptExports || {}

  // ES6 modules interop
  var type = typeof rawScriptExports.default
  if (type === 'object' || type === 'function') {
    esModule = rawScriptExports
    scriptExports = rawScriptExports.default
  }

  // Vue.extend constructor export interop
  var options = typeof scriptExports === 'function'
    ? scriptExports.options
    : scriptExports

  // render functions
  if (compiledTemplate) {
    options.render = compiledTemplate.render
    options.staticRenderFns = compiledTemplate.staticRenderFns
  }

  // scopedId
  if (scopeId) {
    options._scopeId = scopeId
  }

  // inject cssModules
  if (cssModules) {
    var computed = options.computed || (options.computed = {})
    Object.keys(cssModules).forEach(function (key) {
      var module = cssModules[key]
      computed[key] = function () { return module }
    })
  }

  return {
    esModule: esModule,
    exports: scriptExports,
    options: options
  }
}


/***/ }),

/***/ 224:
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(457)

var Component = __webpack_require__(10)(
  /* script */
  __webpack_require__(246),
  /* template */
  __webpack_require__(451),
  /* scopeId */
  null,
  /* cssModules */
  null
)
Component.options.__file = "/Users/amitavroy/code/pack-inferno/resources/assets/js/components/ConfirmModal.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key !== "__esModule"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] ConfirmModal.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-2a094d08", Component.options)
  } else {
    hotAPI.reload("data-v-2a094d08", Component.options)
  }
})()}

module.exports = Component.exports


/***/ }),

/***/ 225:
/***/ (function(module, exports, __webpack_require__) {

/*
  MIT License http://www.opensource.org/licenses/mit-license.php
  Author Tobias Koppers @sokra
  Modified by Evan You @yyx990803
*/

var hasDocument = typeof document !== 'undefined'

if (typeof DEBUG !== 'undefined' && DEBUG) {
  if (!hasDocument) {
    throw new Error(
    'vue-style-loader cannot be used in a non-browser environment. ' +
    "Use { target: 'node' } in your Webpack config to indicate a server-rendering environment."
  ) }
}

var listToStyles = __webpack_require__(459)

/*
type StyleObject = {
  id: number;
  parts: Array<StyleObjectPart>
}

type StyleObjectPart = {
  css: string;
  media: string;
  sourceMap: ?string
}
*/

var stylesInDom = {/*
  [id: number]: {
    id: number,
    refs: number,
    parts: Array<(obj?: StyleObjectPart) => void>
  }
*/}

var head = hasDocument && (document.head || document.getElementsByTagName('head')[0])
var singletonElement = null
var singletonCounter = 0
var isProduction = false
var noop = function () {}

// Force single-tag solution on IE6-9, which has a hard limit on the # of <style>
// tags it will allow on a page
var isOldIE = typeof navigator !== 'undefined' && /msie [6-9]\b/.test(navigator.userAgent.toLowerCase())

module.exports = function (parentId, list, _isProduction) {
  isProduction = _isProduction

  var styles = listToStyles(parentId, list)
  addStylesToDom(styles)

  return function update (newList) {
    var mayRemove = []
    for (var i = 0; i < styles.length; i++) {
      var item = styles[i]
      var domStyle = stylesInDom[item.id]
      domStyle.refs--
      mayRemove.push(domStyle)
    }
    if (newList) {
      styles = listToStyles(parentId, newList)
      addStylesToDom(styles)
    } else {
      styles = []
    }
    for (var i = 0; i < mayRemove.length; i++) {
      var domStyle = mayRemove[i]
      if (domStyle.refs === 0) {
        for (var j = 0; j < domStyle.parts.length; j++) {
          domStyle.parts[j]()
        }
        delete stylesInDom[domStyle.id]
      }
    }
  }
}

function addStylesToDom (styles /* Array<StyleObject> */) {
  for (var i = 0; i < styles.length; i++) {
    var item = styles[i]
    var domStyle = stylesInDom[item.id]
    if (domStyle) {
      domStyle.refs++
      for (var j = 0; j < domStyle.parts.length; j++) {
        domStyle.parts[j](item.parts[j])
      }
      for (; j < item.parts.length; j++) {
        domStyle.parts.push(addStyle(item.parts[j]))
      }
      if (domStyle.parts.length > item.parts.length) {
        domStyle.parts.length = item.parts.length
      }
    } else {
      var parts = []
      for (var j = 0; j < item.parts.length; j++) {
        parts.push(addStyle(item.parts[j]))
      }
      stylesInDom[item.id] = { id: item.id, refs: 1, parts: parts }
    }
  }
}

function listToStyles (parentId, list) {
  var styles = []
  var newStyles = {}
  for (var i = 0; i < list.length; i++) {
    var item = list[i]
    var id = item[0]
    var css = item[1]
    var media = item[2]
    var sourceMap = item[3]
    var part = { css: css, media: media, sourceMap: sourceMap }
    if (!newStyles[id]) {
      part.id = parentId + ':0'
      styles.push(newStyles[id] = { id: id, parts: [part] })
    } else {
      part.id = parentId + ':' + newStyles[id].parts.length
      newStyles[id].parts.push(part)
    }
  }
  return styles
}

function createStyleElement () {
  var styleElement = document.createElement('style')
  styleElement.type = 'text/css'
  head.appendChild(styleElement)
  return styleElement
}

function addStyle (obj /* StyleObjectPart */) {
  var update, remove
  var styleElement = document.querySelector('style[data-vue-ssr-id~="' + obj.id + '"]')
  var hasSSR = styleElement != null

  // if in production mode and style is already provided by SSR,
  // simply do nothing.
  if (hasSSR && isProduction) {
    return noop
  }

  if (isOldIE) {
    // use singleton mode for IE9.
    var styleIndex = singletonCounter++
    styleElement = singletonElement || (singletonElement = createStyleElement())
    update = applyToSingletonTag.bind(null, styleElement, styleIndex, false)
    remove = applyToSingletonTag.bind(null, styleElement, styleIndex, true)
  } else {
    // use multi-style-tag mode in all other cases
    styleElement = styleElement || createStyleElement()
    update = applyToTag.bind(null, styleElement)
    remove = function () {
      styleElement.parentNode.removeChild(styleElement)
    }
  }

  if (!hasSSR) {
    update(obj)
  }

  return function updateStyle (newObj /* StyleObjectPart */) {
    if (newObj) {
      if (newObj.css === obj.css &&
          newObj.media === obj.media &&
          newObj.sourceMap === obj.sourceMap) {
        return
      }
      update(obj = newObj)
    } else {
      remove()
    }
  }
}

var replaceText = (function () {
  var textStore = []

  return function (index, replacement) {
    textStore[index] = replacement
    return textStore.filter(Boolean).join('\n')
  }
})()

function applyToSingletonTag (styleElement, index, remove, obj) {
  var css = remove ? '' : obj.css

  if (styleElement.styleSheet) {
    styleElement.styleSheet.cssText = replaceText(index, css)
  } else {
    var cssNode = document.createTextNode(css)
    var childNodes = styleElement.childNodes
    if (childNodes[index]) styleElement.removeChild(childNodes[index])
    if (childNodes.length) {
      styleElement.insertBefore(cssNode, childNodes[index])
    } else {
      styleElement.appendChild(cssNode)
    }
  }
}

function applyToTag (styleElement, obj) {
  var css = obj.css
  var media = obj.media
  var sourceMap = obj.sourceMap

  if (media) {
    styleElement.setAttribute('media', media)
  }

  if (sourceMap) {
    // https://developer.chrome.com/devtools/docs/javascript-debugging
    // this makes source maps inside style tags work properly in Chrome
    css += '\n/*# sourceURL=' + sourceMap.sources[0] + ' */'
    // http://stackoverflow.com/a/26603875
    css += '\n/*# sourceMappingURL=data:application/json;base64,' + btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap)))) + ' */'
  }

  if (styleElement.styleSheet) {
    styleElement.styleSheet.cssText = css
  } else {
    while (styleElement.firstChild) {
      styleElement.removeChild(styleElement.firstChild)
    }
    styleElement.appendChild(document.createTextNode(css))
  }
}


/***/ }),

/***/ 226:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue__ = __webpack_require__(5);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_vue_router__ = __webpack_require__(61);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_axios__ = __webpack_require__(56);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_axios___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2_axios__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_vue_axios__ = __webpack_require__(59);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_vue_axios___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_3_vue_axios__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__components_SidebarCollapse__ = __webpack_require__(446);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__components_SidebarCollapse___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_4__components_SidebarCollapse__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__components_ImageUpload__ = __webpack_require__(445);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__components_ImageUpload___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_5__components_ImageUpload__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__components_user_activation_UserActivation__ = __webpack_require__(449);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__components_user_activation_UserActivation___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_6__components_user_activation_UserActivation__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7__components_info_box_InfoBox__ = __webpack_require__(448);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7__components_info_box_InfoBox___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_7__components_info_box_InfoBox__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_8__components_UserImage__ = __webpack_require__(447);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_8__components_UserImage___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_8__components_UserImage__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_9__components_ConfirmModal__ = __webpack_require__(224);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_9__components_ConfirmModal___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_9__components_ConfirmModal__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_10__components_ActivityGraph_ActivityGraph__ = __webpack_require__(444);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_10__components_ActivityGraph_ActivityGraph___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_10__components_ActivityGraph_ActivityGraph__);





// importing custom components








// Adding the X-CSRF-Token to all axios request
__WEBPACK_IMPORTED_MODULE_2_axios___default.a.interceptors.request.use(function (config) {
  config.headers['X-CSRF-TOKEN'] = window.Laravel.csrfToken;
  return config;
});
window.eventBus = new __WEBPACK_IMPORTED_MODULE_0_vue___default.a({});

// Making axios available as $http
// so that the ajax calls are not axios dependent
__WEBPACK_IMPORTED_MODULE_0_vue___default.a.prototype.$http = __WEBPACK_IMPORTED_MODULE_2_axios___default.a;

__WEBPACK_IMPORTED_MODULE_0_vue___default.a.use(__WEBPACK_IMPORTED_MODULE_3_vue_axios___default.a, __WEBPACK_IMPORTED_MODULE_2_axios___default.a);
__WEBPACK_IMPORTED_MODULE_0_vue___default.a.use(__WEBPACK_IMPORTED_MODULE_1_vue_router__["default"]);

__WEBPACK_IMPORTED_MODULE_0_vue___default.a.component('sidebar-collapse', __WEBPACK_IMPORTED_MODULE_4__components_SidebarCollapse___default.a);
__WEBPACK_IMPORTED_MODULE_0_vue___default.a.component('image-upload', __WEBPACK_IMPORTED_MODULE_5__components_ImageUpload___default.a);
__WEBPACK_IMPORTED_MODULE_0_vue___default.a.component('user-activation', __WEBPACK_IMPORTED_MODULE_6__components_user_activation_UserActivation___default.a);
__WEBPACK_IMPORTED_MODULE_0_vue___default.a.component('info-box', __WEBPACK_IMPORTED_MODULE_7__components_info_box_InfoBox___default.a);
__WEBPACK_IMPORTED_MODULE_0_vue___default.a.component('user-image', __WEBPACK_IMPORTED_MODULE_8__components_UserImage___default.a);
__WEBPACK_IMPORTED_MODULE_0_vue___default.a.component('confirm-modal', __WEBPACK_IMPORTED_MODULE_9__components_ConfirmModal___default.a);
__WEBPACK_IMPORTED_MODULE_0_vue___default.a.component('activity-graph', __WEBPACK_IMPORTED_MODULE_10__components_ActivityGraph_ActivityGraph___default.a);

var app = new __WEBPACK_IMPORTED_MODULE_0_vue___default.a({
  el: '#app',
  data: {
    message: 'Hello World! 10:35'
  }
});

/***/ }),

/***/ 227:
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 245:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__LineChat__ = __webpack_require__(252);
//
//
//
//
//


/* harmony default export */ __webpack_exports__["default"] = {
  components: {
    'line-chart': __WEBPACK_IMPORTED_MODULE_0__LineChat__["a" /* default */]
  }
};

/***/ }),

/***/ 246:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });

/* harmony default export */ __webpack_exports__["default"] = {
  props: ['url', 'postData', 'message', 'btnClass', 'btnText', 'json', 'refresh'],
  created: function created() {
    if (this.json === true) {
      this.dataToSend = JSON.parse(this.postData);
      console.log('dataToSend', this.dataToSend);
    }

    if (this.refresh === true) {
      this.$on('onConfirm', function () {
        window.location.reload();
      });
    }

    this.dataToSend = this.postData;
  },
  data: function data() {
    return {
      dataToSend: null,
      modalState: false
    };
  },

  methods: {
    handleCloseButton: function handleCloseButton() {
      this.modalState = false;
      window.eventBus.$emit('closed-modal-popup');
    },
    handleActionButton: function handleActionButton() {
      this.modalState = true;
    },
    handleConfirmButton: function handleConfirmButton() {
      var _this = this;

      this.$http.post(this.url, this.dataToSend).then(function (response) {
        console.log('response', response);
        _this.$emit('onConfirm');
        _this.handleCloseButton();
      });
    }
  }
};

/***/ }),

/***/ 247:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_croppie__ = __webpack_require__(57);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_croppie___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_croppie__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__config__ = __webpack_require__(37);



/* harmony default export */ __webpack_exports__["default"] = {
  props: ['imgUrl'],
  mounted: function mounted() {
    this.$on('imgUploaded', function (imageData) {
      this.image = imageData;
      this.croppie.destroy();
      this.setUpCroppie(imageData);
    });
    this.image = this.imgUrl;
    this.setUpCroppie();
  },
  data: function data() {
    return {
      button: {
        name: 'Upload',
        class: 'fa-upload'
      },
      canUpload: true,
      modalVisible: false,
      croppie: null,
      image: null
    };
  },

  methods: {
    uploadFile: function uploadFile() {
      var _this = this;

      this.canUpload = false;
      this.button = {
        name: 'Uploading...',
        class: 'fa-refresh fa-spin'
      };
      this.croppie.result({
        type: 'canvas',
        size: 'viewport'
      }).then(function (response) {
        _this.image = response;
        _this.axios.post(__WEBPACK_IMPORTED_MODULE_1__config__["d" /* uploadProfilePic */], { img: _this.image }).then(function (response) {
          _this.canUpload = true;
          _this.modalVisible = false;
          _this.button = {
            name: 'Upload',
            class: 'fa-upload'
          };
        });
      });
    },
    setUpCroppie: function setUpCroppie() {
      var el = document.getElementById('croppie');
      this.croppie = new __WEBPACK_IMPORTED_MODULE_0_croppie___default.a(el, {
        viewport: { width: 200, height: 200, type: 'circle' },
        boundary: { width: 220, height: 220 },
        showZoomer: true,
        enableOrientation: true
      });
      this.croppie.bind({
        url: this.image
      });
    },
    setUpFileUploader: function setUpFileUploader(e) {
      var files = e.target.files || e.dataTransfer.files;
      if (!files.length) {
        return;
      }
      this.createImage(files[0]);
    },
    createImage: function createImage(file) {
      var image = new Image();
      var reader = new FileReader();
      var vm = this;

      reader.onload = function (e) {
        vm.image = e.target.result;
        vm.$emit('imgUploaded', e.target.result);
      };
      reader.readAsDataURL(file);
    }
  }
};

/***/ }),

/***/ 248:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });

/* harmony default export */ __webpack_exports__["default"] = {
  mounted: function mounted() {
    window.eventBus.$on('closed-modal-popup', function (data) {
      console.log('closed-modal-popup');
    });
  },
  data: function data() {
    return {
      clickable: true
    };
  },

  methods: {
    handleSidebarToggle: function handleSidebarToggle() {
      var _this = this;

      if (this.clickable) {
        this.clickable = false;
        this.$http.post('/api/v1/sidebar-toggle').then(function (response) {
          _this.clickable = true;
        });
      }
    }
  },
  sockets: {
    message: function message() {
      console.log('sidebar collapsed');
    },
    connect: function connect(status) {
      console.log('connected');
    }
  }
};

/***/ }),

/***/ 249:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });

/* harmony default export */ __webpack_exports__["default"] = {
  props: ['src', 'alt', 'imgClass'],
  created: function created() {
    this.imageSrc = this.src;
  },
  data: function data() {
    return {
      imageSrc: ''
    };
  },

  methods: {
    userImageChanged: function userImageChanged(imageSrc) {
      this.imageSrc = imageSrc;
      console.log('image src changed to ', imageSrc);
    }
  },
  sockets: {
    usr_image_uploaded: function usr_image_uploaded(imageSrc) {
      console.log(imageSrc);
      this.userImageChanged(imageSrc);
    }
  }
};

/***/ }),

/***/ 250:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//

/* harmony default export */ __webpack_exports__["default"] = {
  props: ['text', 'number', 'color', 'icon']
};

/***/ }),

/***/ 251:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_lodash__ = __webpack_require__(58);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_lodash___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_lodash__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__ConfirmModal__ = __webpack_require__(224);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__ConfirmModal___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__ConfirmModal__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__config__ = __webpack_require__(37);
//
//




/* harmony default export */ __webpack_exports__["default"] = {
  components: {
    'confirm-modal': __WEBPACK_IMPORTED_MODULE_1__ConfirmModal___default.a
  },
  props: ['users'],
  mounted: function mounted() {
    this.userList = this.users;
  },
  data: function data() {
    return {
      activateUser: __WEBPACK_IMPORTED_MODULE_2__config__["b" /* activateUser */],
      deleteUser: __WEBPACK_IMPORTED_MODULE_2__config__["c" /* deleteUser */],
      userList: []
    };
  },

  methods: {
    removeUserFromList: function removeUserFromList(userToRemove) {
      this.userList = __WEBPACK_IMPORTED_MODULE_0_lodash___default.a.remove(this.userList, function (user) {
        return user.id !== userToRemove.id;
      });
    }
  }
};

/***/ }),

/***/ 252:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue_chartjs__ = __webpack_require__(60);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue_chartjs___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_vue_chartjs__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__config__ = __webpack_require__(37);



/* harmony default export */ __webpack_exports__["a"] = __WEBPACK_IMPORTED_MODULE_0_vue_chartjs__["Line"].extend({
	data: function data() {
		return {
			labels: [],
			dataRows: []
		};
	},
	mounted: function mounted() {
		var _this = this;

		this.$http.post(__WEBPACK_IMPORTED_MODULE_1__config__["a" /* userActivityGraph */]).then(function (response) {
			_this.labels = response.data.data.labels;
			_this.dataRows = response.data.data.count;
			_this.initGraph();
		});
	},

	methods: {
		initGraph: function initGraph() {
			this.renderChart({
				labels: this.labels,
				showLines: true,
				datasets: [{ label: 'My recent activities', backgroundColor: '#dd4b39', data: this.dataRows }]
			}, { responsive: true, maintainAspectRatio: false });
		}
	}
});

/***/ }),

/***/ 301:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(68)();
exports.push([module.i, "\n.modal-background {\n  bottom: 0;\n  left: 0;\n  position: absolute;\n  right: 0;\n  top: 0;\n  background-color: rgba(10, 10, 10, 0.86);\n}\n.modal-content,\n.modal-card {\n  margin: 0 20px;\n  max-height: calc(100vh - 160px);\n  overflow: auto;\n  position: relative;\n  width: 100%;\n  padding: 20px;\n}\n.modal-content h4 {\n  padding-bottom: 20px;\n  text-align: left;\n}\n@media screen and (min-width: 769px) {\n.modal-content,\n  .modal-card {\n    margin: 0 auto;\n    max-height: calc(100vh - 40px);\n    width: 640px;\n}\n}\n.modal-close {\n  -webkit-touch-callout: none;\n  -webkit-user-select: none;\n  -moz-user-select: none;\n  -ms-user-select: none;\n  user-select: none;\n  -moz-appearance: none;\n  -webkit-appearance: none;\n  background-color: rgba(10, 10, 10, 0.2);\n  border: none;\n  border-radius: 290486px;\n  cursor: pointer;\n  display: inline-block;\n  font-size: 1rem;\n  height: 20px;\n  outline: none;\n  position: relative;\n  -webkit-transform: rotate(45deg);\n          transform: rotate(45deg);\n  -webkit-transform-origin: center center;\n          transform-origin: center center;\n  vertical-align: top;\n  width: 20px;\n  background: none;\n  height: 40px;\n  position: fixed;\n  right: 20px;\n  top: 20px;\n  width: 40px;\n}\n.modal-close:before, .modal-close:after {\n  background-color: white;\n  content: \"\";\n  display: block;\n  left: 50%;\n  position: absolute;\n  top: 50%;\n  -webkit-transform: translateX(-50%) translateY(-50%);\n          transform: translateX(-50%) translateY(-50%);\n}\n.modal-close:before {\n  height: 2px;\n  width: 50%;\n}\n.modal-close:after {\n  height: 50%;\n  width: 2px;\n}\n.modal-close:hover, .modal-close:focus {\n  background-color: rgba(10, 10, 10, 0.3);\n}\n.modal-close:active {\n  background-color: rgba(10, 10, 10, 0.4);\n}\n.modal-close.is-small {\n  height: 14px;\n  width: 14px;\n}\n.modal-close.is-medium {\n  height: 26px;\n  width: 26px;\n}\n.modal-close.is-large {\n  height: 30px;\n  width: 30px;\n}\n.modal-card {\n  display: -webkit-box;\n  display: -ms-flexbox;\n  display: flex;\n  -webkit-box-orient: vertical;\n  -webkit-box-direction: normal;\n      -ms-flex-direction: column;\n          flex-direction: column;\n  max-height: calc(100vh - 40px);\n  overflow: hidden;\n}\n.modal-card-head,\n.modal-card-foot {\n  -webkit-box-align: center;\n      -ms-flex-align: center;\n          align-items: center;\n  background-color: whitesmoke;\n  display: -webkit-box;\n  display: -ms-flexbox;\n  display: flex;\n  -ms-flex-negative: 0;\n      flex-shrink: 0;\n  -webkit-box-pack: start;\n      -ms-flex-pack: start;\n          justify-content: flex-start;\n  padding: 20px;\n  position: relative;\n}\n.modal-card-head {\n  border-bottom: 1px solid #dbdbdb;\n  border-top-left-radius: 5px;\n  border-top-right-radius: 5px;\n}\n.modal-card-title {\n  color: #363636;\n  -webkit-box-flex: 1;\n      -ms-flex-positive: 1;\n          flex-grow: 1;\n  -ms-flex-negative: 0;\n      flex-shrink: 0;\n  font-size: 1.5rem;\n  line-height: 1;\n}\n.modal-card-foot {\n  border-bottom-left-radius: 5px;\n  border-bottom-right-radius: 5px;\n  border-top: 1px solid #dbdbdb;\n}\n.modal-card-foot .button:not(:last-child) {\n  margin-right: 10px;\n}\n.modal-card-body {\n  -webkit-overflow-scrolling: touch;\n  background-color: white;\n  -webkit-box-flex: 1;\n      -ms-flex-positive: 1;\n          flex-grow: 1;\n  -ms-flex-negative: 1;\n      flex-shrink: 1;\n  overflow: auto;\n  padding: 20px;\n}\n.modal {\n  bottom: 0;\n  left: 0;\n  position: absolute;\n  right: 0;\n  top: 0;\n  -webkit-box-align: center;\n      -ms-flex-align: center;\n          align-items: center;\n  display: none;\n  -webkit-box-pack: center;\n      -ms-flex-pack: center;\n          justify-content: center;\n  overflow: hidden;\n  position: fixed;\n  z-index: 1986;\n}\n.modal.is-active {\n  display: -webkit-box;\n  display: -ms-flexbox;\n  display: flex;\n}\n", ""]);

/***/ }),

/***/ 302:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(68)();
exports.push([module.i, "\n.Image-upload .Modal {\n  border-top: 1px solid #f4f4f4;\n  margin-top: 10px;\n}\n.Image-upload .Modal h4 {\n    margin-bottom: 20px;\n}\n.Image-upload div#upload-wrapper {\n  text-align: center;\n}\n.Image-upload .input-file {\n  text-align: left;\n  width: 50%;\n  margin: 0px auto;\n  margin-bottom: 20px;\n}\n", ""]);

/***/ }),

/***/ 37:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* unused harmony export apiDomain */
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "d", function() { return uploadProfilePic; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return activateUser; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "c", function() { return deleteUser; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return userActivityGraph; });
var apiDomain = 'http://localhost:8000/';

var uploadProfilePic = apiDomain + 'api/v1/image-upload';
var activateUser = apiDomain + 'api/v1/activate-user';
var deleteUser = apiDomain + 'api/v1/delete-user';
var userActivityGraph = apiDomain + 'api/v1/activity-graph';

/***/ }),

/***/ 444:
/***/ (function(module, exports, __webpack_require__) {

var Component = __webpack_require__(10)(
  /* script */
  __webpack_require__(245),
  /* template */
  __webpack_require__(456),
  /* scopeId */
  null,
  /* cssModules */
  null
)
Component.options.__file = "/Users/amitavroy/code/pack-inferno/resources/assets/js/components/ActivityGraph/ActivityGraph.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key !== "__esModule"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] ActivityGraph.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-ca2dfd20", Component.options)
  } else {
    hotAPI.reload("data-v-ca2dfd20", Component.options)
  }
})()}

module.exports = Component.exports


/***/ }),

/***/ 445:
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(458)

var Component = __webpack_require__(10)(
  /* script */
  __webpack_require__(247),
  /* template */
  __webpack_require__(452),
  /* scopeId */
  null,
  /* cssModules */
  null
)
Component.options.__file = "/Users/amitavroy/code/pack-inferno/resources/assets/js/components/ImageUpload.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key !== "__esModule"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] ImageUpload.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-2aca9f5d", Component.options)
  } else {
    hotAPI.reload("data-v-2aca9f5d", Component.options)
  }
})()}

module.exports = Component.exports


/***/ }),

/***/ 446:
/***/ (function(module, exports, __webpack_require__) {

var Component = __webpack_require__(10)(
  /* script */
  __webpack_require__(248),
  /* template */
  __webpack_require__(453),
  /* scopeId */
  null,
  /* cssModules */
  null
)
Component.options.__file = "/Users/amitavroy/code/pack-inferno/resources/assets/js/components/SidebarCollapse.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key !== "__esModule"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] SidebarCollapse.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-5d90784a", Component.options)
  } else {
    hotAPI.reload("data-v-5d90784a", Component.options)
  }
})()}

module.exports = Component.exports


/***/ }),

/***/ 447:
/***/ (function(module, exports, __webpack_require__) {

var Component = __webpack_require__(10)(
  /* script */
  __webpack_require__(249),
  /* template */
  __webpack_require__(455),
  /* scopeId */
  null,
  /* cssModules */
  null
)
Component.options.__file = "/Users/amitavroy/code/pack-inferno/resources/assets/js/components/UserImage.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key !== "__esModule"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] UserImage.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-a83c769e", Component.options)
  } else {
    hotAPI.reload("data-v-a83c769e", Component.options)
  }
})()}

module.exports = Component.exports


/***/ }),

/***/ 448:
/***/ (function(module, exports, __webpack_require__) {

var Component = __webpack_require__(10)(
  /* script */
  __webpack_require__(250),
  /* template */
  __webpack_require__(454),
  /* scopeId */
  null,
  /* cssModules */
  null
)
Component.options.__file = "/Users/amitavroy/code/pack-inferno/resources/assets/js/components/info-box/InfoBox.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key !== "__esModule"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] InfoBox.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-65fc1ac9", Component.options)
  } else {
    hotAPI.reload("data-v-65fc1ac9", Component.options)
  }
})()}

module.exports = Component.exports


/***/ }),

/***/ 449:
/***/ (function(module, exports, __webpack_require__) {

var Component = __webpack_require__(10)(
  /* script */
  __webpack_require__(251),
  /* template */
  __webpack_require__(450),
  /* scopeId */
  null,
  /* cssModules */
  null
)
Component.options.__file = "/Users/amitavroy/code/pack-inferno/resources/assets/js/components/user-activation/UserActivation.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key !== "__esModule"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] UserActivation.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-1c27f247", Component.options)
  } else {
    hotAPI.reload("data-v-1c27f247", Component.options)
  }
})()}

module.exports = Component.exports


/***/ }),

/***/ 450:
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "UserActivation"
  }, [(_vm.userList.length > 0) ? _c('table', {
    staticClass: "table table-bordered table-striped table-hover"
  }, [_vm._m(0), _vm._v(" "), _c('tbody', _vm._l((_vm.userList), function(user) {
    return _c('tr', [_c('td', [_vm._v(_vm._s(user.id))]), _vm._v(" "), _c('td', [_vm._v(_vm._s(user.name))]), _vm._v(" "), _c('td', [_vm._v(_vm._s(user.email))]), _vm._v(" "), _c('td', [_vm._v(_vm._s((user.activation_token && user.activation_token.token) ? user.activation_token.token : ''))]), _vm._v(" "), _c('td', {
      staticClass: "col-sm-2",
      attrs: {
        "align": "right"
      }
    }, [_c('div', {
      staticClass: "pull-left gap-left gap-10 activate-button"
    }, [_c('confirm-modal', {
      attrs: {
        "btn-text": "<i class=\"fa fa-check\"></i> Activate",
        "btn-class": "btn-success",
        "url": _vm.activateUser,
        "post-data": {
          userId: user.id
        },
        "message": "Are you sure you want to activate this user?"
      },
      on: {
        "onConfirm": function($event) {
          _vm.removeUserFromList(user)
        }
      }
    })], 1), _vm._v(" "), _c('div', {
      staticClass: "pull-left gap-left gap-10 delete-button"
    }, [_c('confirm-modal', {
      attrs: {
        "btn-text": "<i class=\"fa fa-trash\"></i> Delete",
        "btn-class": "btn-danger",
        "url": _vm.deleteUser,
        "post-data": {
          userId: user.id
        },
        "message": "Are you sure you want to delete this user?"
      },
      on: {
        "onConfirm": function($event) {
          _vm.removeUserFromList(user)
        }
      }
    })], 1)])])
  }))]) : _c('div', [_c('h3', [_vm._v("No users pending for activation")])])])
},staticRenderFns: [function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('thead', [_c('tr', [_c('th', [_vm._v("#")]), _vm._v(" "), _c('th', [_vm._v("Name")]), _vm._v(" "), _c('th', [_vm._v("Email")]), _vm._v(" "), _c('th', [_vm._v("Token")]), _vm._v(" "), _c('th')])])
}]}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-1c27f247", module.exports)
  }
}

/***/ }),

/***/ 451:
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "ConfirmModalWrapper"
  }, [_c('button', {
    staticClass: "btn btn-xs",
    class: _vm.btnClass,
    on: {
      "click": _vm.handleActionButton
    }
  }, [_c('div', {
    domProps: {
      "innerHTML": _vm._s(_vm.btnText)
    }
  })]), _vm._v(" "), _c('div', {
    staticClass: "modal",
    class: {
      'is-active': _vm.modalState
    }
  }, [_c('div', {
    staticClass: "modal-background"
  }), _vm._v(" "), _c('div', {
    staticClass: "modal-content"
  }, [_c('h4', [_vm._v(_vm._s(_vm.message))]), _vm._v(" "), _c('button', {
    staticClass: "btn btn-success",
    on: {
      "click": _vm.handleConfirmButton
    }
  }, [_vm._v("Ok")]), _vm._v(" "), _c('button', {
    staticClass: "btn btn-warning",
    on: {
      "click": _vm.handleCloseButton
    }
  }, [_vm._v("Cancel")])]), _vm._v(" "), _c('button', {
    staticClass: "modal-close",
    on: {
      "click": _vm.handleCloseButton
    }
  })])])
},staticRenderFns: []}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-2a094d08", module.exports)
  }
}

/***/ }),

/***/ 452:
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "Image-upload-wrapper Image-upload"
  }, [_c('div', {
    attrs: {
      "id": "croppie"
    }
  }), _vm._v(" "), _c('div', {
    attrs: {
      "id": "upload-wrapper"
    }
  }, [_c('button', {
    staticClass: "btn btn-primary btn-sm",
    on: {
      "click": function($event) {
        _vm.modalVisible = true
      }
    }
  }, [_c('i', {
    staticClass: "fa fa-camera"
  }), _vm._v(" Upload image\n    ")]), _vm._v(" "), (_vm.modalVisible) ? _c('div', {
    staticClass: "Modal"
  }, [_c('h4', [_vm._v("Upload an Image")]), _vm._v(" "), _c('div', {
    staticClass: "input-file"
  }, [_c('input', {
    attrs: {
      "name": "image-upload",
      "type": "file",
      "id": "upload-image"
    },
    on: {
      "change": _vm.setUpFileUploader
    }
  })]), _vm._v(" "), _c('button', {
    staticClass: "btn btn-success",
    attrs: {
      "id": "uploadFileCall"
    },
    on: {
      "click": _vm.uploadFile
    }
  }, [_c('i', {
    staticClass: "fa",
    class: _vm.button.class
  }), _vm._v(" " + _vm._s(_vm.button.name) + "\n      ")]), _vm._v(" "), _c('button', {
    staticClass: "btn btn-warning",
    on: {
      "click": function($event) {
        _vm.modalVisible = false
      }
    }
  }, [_c('i', {
    staticClass: "fa fa-times"
  }), _vm._v(" Cancel\n      ")])]) : _vm._e()])])
},staticRenderFns: []}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-2aca9f5d", module.exports)
  }
}

/***/ }),

/***/ 453:
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('a', {
    staticClass: "sidebar-toggle",
    attrs: {
      "href": "javascript:void(0);",
      "data-toggle": "offcanvas",
      "role": "button"
    },
    on: {
      "click": _vm.handleSidebarToggle
    }
  }, [_c('span', {
    staticClass: "sr-only"
  }, [_vm._v("Toggle navigation")])])
},staticRenderFns: []}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-5d90784a", module.exports)
  }
}

/***/ }),

/***/ 454:
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "info-box"
  }, [_c('span', {
    staticClass: "info-box-icon",
    class: _vm.color
  }, [_c('i', {
    staticClass: "fa",
    class: _vm.icon
  })]), _vm._v(" "), _c('div', {
    staticClass: "info-box-content"
  }, [_c('span', {
    staticClass: "info-box-text"
  }, [_vm._v(_vm._s(_vm.text))]), _vm._v(" "), _c('span', {
    staticClass: "info-box-number"
  }, [_vm._v(_vm._s(_vm.number))])])])
},staticRenderFns: []}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-65fc1ac9", module.exports)
  }
}

/***/ }),

/***/ 455:
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('img', {
    class: _vm.imgClass,
    attrs: {
      "src": _vm.imageSrc,
      "alt": _vm.alt
    }
  })
},staticRenderFns: []}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-a83c769e", module.exports)
  }
}

/***/ }),

/***/ 456:
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "ActivityGraph"
  }, [_c('line-chart')], 1)
},staticRenderFns: []}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-ca2dfd20", module.exports)
  }
}

/***/ }),

/***/ 457:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(301);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(225)("85538428", content, false);
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-rewriter.js?id=data-v-2a094d08!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./ConfirmModal.vue", function() {
     var newContent = require("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-rewriter.js?id=data-v-2a094d08!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./ConfirmModal.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 458:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(302);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(225)("473cdc46", content, false);
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-rewriter.js?id=data-v-2aca9f5d!../../../../node_modules/sass-loader/lib/loader.js!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./ImageUpload.vue", function() {
     var newContent = require("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-rewriter.js?id=data-v-2aca9f5d!../../../../node_modules/sass-loader/lib/loader.js!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./ImageUpload.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 459:
/***/ (function(module, exports) {

/**
 * Translates the list format produced by css-loader into something
 * easier to manipulate.
 */
module.exports = function listToStyles (parentId, list) {
  var styles = []
  var newStyles = {}
  for (var i = 0; i < list.length; i++) {
    var item = list[i]
    var id = item[0]
    var css = item[1]
    var media = item[2]
    var sourceMap = item[3]
    var part = {
      id: parentId + ':' + i,
      css: css,
      media: media,
      sourceMap: sourceMap
    }
    if (!newStyles[id]) {
      styles.push(newStyles[id] = { id: id, parts: [part] })
    } else {
      newStyles[id].parts.push(part)
    }
  }
  return styles
}


/***/ }),

/***/ 460:
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(226);
module.exports = __webpack_require__(227);


/***/ }),

/***/ 68:
/***/ (function(module, exports) {

/*
	MIT License http://www.opensource.org/licenses/mit-license.php
	Author Tobias Koppers @sokra
*/
// css base code, injected by the css-loader
module.exports = function() {
	var list = [];

	// return the list of modules as css string
	list.toString = function toString() {
		var result = [];
		for(var i = 0; i < this.length; i++) {
			var item = this[i];
			if(item[2]) {
				result.push("@media " + item[2] + "{" + item[1] + "}");
			} else {
				result.push(item[1]);
			}
		}
		return result.join("");
	};

	// import a list of modules into the list
	list.i = function(modules, mediaQuery) {
		if(typeof modules === "string")
			modules = [[null, modules, ""]];
		var alreadyImportedModules = {};
		for(var i = 0; i < this.length; i++) {
			var id = this[i][0];
			if(typeof id === "number")
				alreadyImportedModules[id] = true;
		}
		for(i = 0; i < modules.length; i++) {
			var item = modules[i];
			// skip already imported module
			// this implementation is not 100% perfect for weird media query combinations
			//  when a module is imported multiple times with different media queries.
			//  I hope this will never occur (Hey this way we have smaller bundles)
			if(typeof item[0] !== "number" || !alreadyImportedModules[item[0]]) {
				if(mediaQuery && !item[2]) {
					item[2] = mediaQuery;
				} else if(mediaQuery) {
					item[2] = "(" + item[2] + ") and (" + mediaQuery + ")";
				}
				list.push(item);
			}
		}
	};
	return list;
};


/***/ })

},[460]);