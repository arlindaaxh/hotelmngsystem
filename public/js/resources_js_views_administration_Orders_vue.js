"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_views_administration_Orders_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/administration/Orders.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/administration/Orders.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  data: function data() {
    return {
      loading: false,
      query: ""
    };
  },
  methods: {
    tableCellStyle: function tableCellStyle(_ref) {
      var row = _ref.row,
          column = _ref.column,
          rowIndex = _ref.rowIndex,
          columnIndex = _ref.columnIndex;
      return {
        'color': '#2c3e50'
      };
    },
    addOrder: function addOrder() {
      this.$router.push({
        name: 'add-order',
        params: {
          insertEdit: 'add'
        }
      });
    }
  }
});

/***/ }),

/***/ "./resources/js/views/administration/Orders.vue":
/*!******************************************************!*\
  !*** ./resources/js/views/administration/Orders.vue ***!
  \******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Orders_vue_vue_type_template_id_4d324367___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Orders.vue?vue&type=template&id=4d324367& */ "./resources/js/views/administration/Orders.vue?vue&type=template&id=4d324367&");
/* harmony import */ var _Orders_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Orders.vue?vue&type=script&lang=js& */ "./resources/js/views/administration/Orders.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Orders_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Orders_vue_vue_type_template_id_4d324367___WEBPACK_IMPORTED_MODULE_0__.render,
  _Orders_vue_vue_type_template_id_4d324367___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/administration/Orders.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/views/administration/Orders.vue?vue&type=script&lang=js&":
/*!*******************************************************************************!*\
  !*** ./resources/js/views/administration/Orders.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Orders_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Orders.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/administration/Orders.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Orders_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/administration/Orders.vue?vue&type=template&id=4d324367&":
/*!*************************************************************************************!*\
  !*** ./resources/js/views/administration/Orders.vue?vue&type=template&id=4d324367& ***!
  \*************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Orders_vue_vue_type_template_id_4d324367___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Orders_vue_vue_type_template_id_4d324367___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Orders_vue_vue_type_template_id_4d324367___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Orders.vue?vue&type=template&id=4d324367& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/administration/Orders.vue?vue&type=template&id=4d324367&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/administration/Orders.vue?vue&type=template&id=4d324367&":
/*!****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/administration/Orders.vue?vue&type=template&id=4d324367& ***!
  \****************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _vm.$route.name === "orders"
    ? _c(
        "div",
        {
          directives: [
            {
              name: "loading",
              rawName: "v-loading",
              value: _vm.loading,
              expression: "loading"
            }
          ],
          staticClass: "form-max-width"
        },
        [
          _vm._m(0),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "one-column-list" },
            [
              _c(
                "div",
                { staticClass: "flexed justify-between m-b-20" },
                [
                  _c(
                    "el-input",
                    {
                      staticClass: "search-input",
                      style: "max-width:450px",
                      attrs: {
                        size: "big",
                        placeholder: "Search orders by order number"
                      },
                      model: {
                        value: _vm.query,
                        callback: function($$v) {
                          _vm.query = $$v
                        },
                        expression: "query"
                      }
                    },
                    [
                      _c("i", {
                        staticClass: "el-icon-search el-input__icon",
                        attrs: { slot: "suffix" },
                        slot: "suffix"
                      })
                    ]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    [
                      _c(
                        "el-button",
                        {
                          staticStyle: {
                            "background-color": "#ff7b50",
                            "border-radius": "15px",
                            color: "white"
                          },
                          attrs: { size: "big" },
                          on: {
                            click: function($event) {
                              return _vm.addOrder()
                            }
                          }
                        },
                        [_vm._v("New")]
                      )
                    ],
                    1
                  )
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "el-table",
                {
                  staticClass: "table mt-50 pointer",
                  staticStyle: { width: "100%" },
                  attrs: {
                    data: _vm.filteredOrders,
                    stripe: "",
                    "default-sort": { prop: "name", order: "ascending" },
                    "header-cell-class-name": "table-header",
                    "header-cell-style": _vm.tableCellStyle
                  },
                  on: { "row-click": _vm.editOrder }
                },
                [
                  _c("el-table-column", {
                    attrs: { prop: "serial_number", label: "Order Number" }
                  }),
                  _vm._v(" "),
                  _c("el-table-column", {
                    attrs: { prop: "date", label: "Date" }
                  }),
                  _vm._v(" "),
                  _c("el-table-column", {
                    attrs: { prop: "vendor_id", label: "Vendor" }
                  }),
                  _vm._v(" "),
                  _c("el-table-column", {
                    attrs: { prop: "price", label: "Price" }
                  }),
                  _vm._v(" "),
                  _c("el-table-column", {
                    attrs: { prop: "items", label: "Items" }
                  })
                ],
                1
              ),
              _vm._v(" "),
              !_vm.loading &&
              _vm.filteredProducts &&
              _vm.filteredProducts.length === 0
                ? _c("el-alert", {
                    staticClass: "mt-30",
                    attrs: {
                      type: "info",
                      closable: false,
                      title: "No results found",
                      "show-icon": ""
                    }
                  })
                : _vm._e()
            ],
            1
          )
        ]
      )
    : _c("div", [_c("router-view")], 1)
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "div",
      { staticClass: "shortcuts-header flexed justify-between" },
      [_c("h4", [_vm._v("Orders")])]
    )
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js":
/*!********************************************************************!*\
  !*** ./node_modules/vue-loader/lib/runtime/componentNormalizer.js ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ normalizeComponent)
/* harmony export */ });
/* globals __VUE_SSR_CONTEXT__ */

// IMPORTANT: Do NOT use ES2015 features in this file (except for modules).
// This module is a runtime utility for cleaner component module output and will
// be included in the final webpack user bundle.

function normalizeComponent (
  scriptExports,
  render,
  staticRenderFns,
  functionalTemplate,
  injectStyles,
  scopeId,
  moduleIdentifier, /* server only */
  shadowMode /* vue-cli only */
) {
  // Vue.extend constructor export interop
  var options = typeof scriptExports === 'function'
    ? scriptExports.options
    : scriptExports

  // render functions
  if (render) {
    options.render = render
    options.staticRenderFns = staticRenderFns
    options._compiled = true
  }

  // functional template
  if (functionalTemplate) {
    options.functional = true
  }

  // scopedId
  if (scopeId) {
    options._scopeId = 'data-v-' + scopeId
  }

  var hook
  if (moduleIdentifier) { // server build
    hook = function (context) {
      // 2.3 injection
      context =
        context || // cached call
        (this.$vnode && this.$vnode.ssrContext) || // stateful
        (this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext) // functional
      // 2.2 with runInNewContext: true
      if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {
        context = __VUE_SSR_CONTEXT__
      }
      // inject component styles
      if (injectStyles) {
        injectStyles.call(this, context)
      }
      // register component module identifier for async chunk inferrence
      if (context && context._registeredComponents) {
        context._registeredComponents.add(moduleIdentifier)
      }
    }
    // used by ssr in case component is cached and beforeCreate
    // never gets called
    options._ssrRegister = hook
  } else if (injectStyles) {
    hook = shadowMode
      ? function () {
        injectStyles.call(
          this,
          (options.functional ? this.parent : this).$root.$options.shadowRoot
        )
      }
      : injectStyles
  }

  if (hook) {
    if (options.functional) {
      // for template-only hot-reload because in that case the render fn doesn't
      // go through the normalizer
      options._injectStyles = hook
      // register for functional component in vue file
      var originalRender = options.render
      options.render = function renderWithStyleInjection (h, context) {
        hook.call(context)
        return originalRender(h, context)
      }
    } else {
      // inject component registration as beforeCreate hook
      var existing = options.beforeCreate
      options.beforeCreate = existing
        ? [].concat(existing, hook)
        : [hook]
    }
  }

  return {
    exports: scriptExports,
    options: options
  }
}


/***/ })

}]);