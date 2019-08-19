/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/models/TodoList.js":
/*!*****************************************!*\
  !*** ./resources/js/models/TodoList.js ***!
  \*****************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var TodoList = function TodoList(id, title, items) {
  _classCallCheck(this, TodoList);

  this.id = id;
  this.title = title;
  this.todo_list_items = items;
};

/* harmony default export */ __webpack_exports__["default"] = (TodoList);

/***/ }),

/***/ "./resources/js/models/TodoListItem.js":
/*!*********************************************!*\
  !*** ./resources/js/models/TodoListItem.js ***!
  \*********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var TodoListItem = function TodoListItem(id, name, isDone, todoListId) {
  _classCallCheck(this, TodoListItem);

  this.id = id;
  this.name = name;
  this.isDone = isDone == 1 ? true : false;
  this.todoListId = todoListId;
};

/* harmony default export */ __webpack_exports__["default"] = (TodoListItem);

/***/ }),

/***/ "./resources/js/todos.js":
/*!*******************************!*\
  !*** ./resources/js/todos.js ***!
  \*******************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _models_TodoList__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./models/TodoList */ "./resources/js/models/TodoList.js");
/* harmony import */ var _models_TodoListItem__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./models/TodoListItem */ "./resources/js/models/TodoListItem.js");
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

/* const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default)); */
//Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


window.Event = new (
/*#__PURE__*/
function () {
  function _class() {
    _classCallCheck(this, _class);

    this.vue = new Vue();
  }

  _createClass(_class, [{
    key: "fire",
    value: function fire(event) {
      var data = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;
      this.vue.$emit(event, data);
    }
  }, {
    key: "listen",
    value: function listen(event, callback) {
      this.vue.$on(event, callback);
    }
  }]);

  return _class;
}())();
var app = new Vue({
  el: '#app',
  data: {
    newNote: '',
    newListName: '',
    todoLists: []
  },
  methods: {
    loadTodoLists: function loadTodoLists() {
      var _this = this;

      axios.get('/todoLists').then(function (response) {
        var data = response.data;
        _this.todoLists = [];
        data.forEach(function (row) {
          var items = [];
          row.todo_list_items.forEach(function (item) {
            var todoListItem = new _models_TodoListItem__WEBPACK_IMPORTED_MODULE_1__["default"](item.id, item.name, item.is_done, item.todo_list_id);
            items.push(todoListItem);
          });
          var todoList = new _models_TodoList__WEBPACK_IMPORTED_MODULE_0__["default"](row.id, row.title, items);

          _this.todoLists.push(todoList);
        });
      });
    }
  },
  created: function created() {
    var _this2 = this;

    Event.listen('newListAdded', function (newItem) {
      _this2.todoLists.unshift(newItem);
    });
    Event.listen('listDeleted', function (deletedList) {
      for (var i = 0; i < _this2.todoLists.length; i++) {
        var list = _this2.todoLists[i];

        if (list['id'] == deletedList['id']) {
          _this2.todoLists.splice(i, 1);

          break;
        }
      }
    });
  },
  mounted: function mounted() {
    this.loadTodoLists();
  }
});

/***/ }),

/***/ 1:
/*!*************************************!*\
  !*** multi ./resources/js/todos.js ***!
  \*************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /home/vukhuu/code/laravel/to-do-app/resources/js/todos.js */"./resources/js/todos.js");


/***/ })

/******/ });