"use strict";var _typeof="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},_createClass=function(){function a(e,o){for(var t=0;t<o.length;t++){var a=o[t];a.enumerable=a.enumerable||!1,a.configurable=!0,"value"in a&&(a.writable=!0),Object.defineProperty(e,a.key,a)}}return function(e,o,t){return o&&a(e.prototype,o),t&&a(e,t),e}}();function _classCallCheck(e,o){if(!(e instanceof o))throw new TypeError("Cannot call a class as a function")}!function(i){var e=function(){function e(){var a=this;_classCallCheck(this,e),this.button="[wpopal-button-move]",i(this.button).on("click",function(e){var o=e.target.getAttribute("data-id"),t=e.target.getAttribute("data-type");"section"===t?wp.customize.section(o).expand():"control"===t&&a.moveControl(o,t)}),wp.customize.previewer.bind("preview-move",function(e){"section"===e.type?wp.customize.section(e.id)&&wp.customize.section(e.id).expand():"control"===e.type&&a.moveControl(e.id,e.trigger)})}return _createClass(e,[{key:"moveControl",value:function(e,t){var a=wp.customize.control(e);a.expand(),setTimeout(function(){if(t)1<(t=t.split("|")).length&&i(a.selector+" "+t[0]).trigger(t[1]);else{var e=i("input,select, button, textarea",a.selector).first(),o=e.val();e.focus(),e.val(""),e.val(o)}},550)}}]),e}(),o=function e(){_classCallCheck(this,e),i("input.alpha-color-control").alphaColorPicker()},r=function(){function e(){_classCallCheck(this,e)}return _createClass(e,null,[{key:"getId",value:function(e){return e.data("id")}},{key:"setValue",value:function(e,o){wp.customize.control(this.getId(e)).setting.set(o)}}]),e}();wp.customize.bind("ready",function(){wp.customize("wpopal_colors_header_skin",function(a){var e=function(){var e={wpopal_colors_header_bg:{value:"custom",equal:"="},wpopal_colors_header_color:{value:"custom",equal:"="},wpopal_colors_topbar_bg:{value:"custom",equal:"="},wpopal_colors_topbar_color:{value:"custom",equal:"="}},o=""+a.get();for(var t in e)i("#customize-control-"+t).hide(),"!="===e[t].equal?e[t].value!==o&&i("#customize-control-"+t).show():e[t].value===o&&i("#customize-control-"+t).show()};e(),a.bind(e)}),wp.customize("wpopal_colors_footer_skin",function(a){var e=function(){var e={wpopal_colors_footer_bg:{value:"custom",equal:"="},wpopal_colors_footer_color:{value:"custom",equal:"="},wpopal_colors_copyright_bg:{value:"custom",equal:"="},wpopal_colors_copyright_color:{value:"custom",equal:"="}},o=""+a.get();for(var t in e)i("#customize-control-"+t).hide(),"!="===e[t].equal?e[t].value!==o&&i("#customize-control-"+t).show():e[t].value===o&&i("#customize-control-"+t).show()};e(),a.bind(e)}),wp.customize("wpopal_colors_buttons_enable_custom",function(a){var e=function(){var e={wpopal_colors_title_buttons_primary:{value:"true",equal:"="},wpopal_colors_buttons_primary_bg:{value:"true",equal:"="},wpopal_colors_buttons_primary_border:{value:"true",equal:"="},wpopal_colors_buttons_primary_color:{value:"true",equal:"="},wpopal_colors_buttons_primary_color_outline:{value:"true",equal:"="},wpopal_colors_title_buttons_secondary:{value:"true",equal:"="},wpopal_colors_buttons_secondary_bg:{value:"true",equal:"="},wpopal_colors_buttons_secondary_border:{value:"true",equal:"="},wpopal_colors_buttons_secondary_color:{value:"true",equal:"="},wpopal_colors_buttons_secondary_color_outline:{value:"true",equal:"="},wpopal_colors_title_buttons_primary_hover:{value:"true",equal:"="},wpopal_colors_buttons_primary_hover_bg:{value:"true",equal:"="},wpopal_colors_buttons_primary_hover_border:{value:"true",equal:"="},wpopal_colors_buttons_primary_hover_color:{value:"true",equal:"="},wpopal_colors_title_buttons_secondary_hover:{value:"true",equal:"="},wpopal_colors_buttons_secondary_hover_bg:{value:"true",equal:"="},wpopal_colors_buttons_secondary_hover_border:{value:"true",equal:"="},wpopal_colors_buttons_secondary_hover_color:{value:"true",equal:"="}},o=""+a.get();for(var t in e)i("#customize-control-"+t).hide(),"!="===e[t].equal?e[t].value!==o&&i("#customize-control-"+t).show():e[t].value===o&&i("#customize-control-"+t).show()};e(),a.bind(e)}),wp.customize("wpopal_layout_general_layout_mode",function(a){var e=function(){var e={wpopal_layout_general_layout_boxed_width:{value:"boxed",equal:"="}},o=""+a.get();for(var t in e)i("#customize-control-"+t).hide(),"!="===e[t].equal?e[t].value!==o&&i("#customize-control-"+t).show():e[t].value===o&&i("#customize-control-"+t).show()};e(),a.bind(e)}),wp.customize("wpopal_layout_general_content_width_type",function(a){var e=function(){var e={wpopal_layout_general_content_width_px:{value:"px",equal:"="},wpopal_layout_general_content_width_percent:{value:"%",equal:"="}},o=""+a.get();for(var t in e)i("#customize-control-"+t).hide(),"!="===e[t].equal?e[t].value!==o&&i("#customize-control-"+t).show():e[t].value===o&&i("#customize-control-"+t).show()};e(),a.bind(e)}),wp.customize("wpopal_layout_sidebar_is_boxed",function(a){var e=function(){var e={wpopal_layout_sidebar_title_outside:{value:"true",equal:"="},wpopal_layout_sidebar_sidebar_heading_title:{value:"true",equal:"="},wpopal_layout_sidebar_padding_inside_boxed:{value:"true",equal:"="},wpopal_colors_sidebar_border_color:{value:"true",equal:"="},wpopal_colors_sidebar_bg_color:{value:"true",equal:"="},wpopal_layout_sidebar_padding:{value:"true",equal:"="},wpopal_layout_sidebar_margin:{value:"true",equal:"="}},o=""+a.get();for(var t in e)i("#customize-control-"+t).hide(),"!="===e[t].equal?e[t].value!==o&&i("#customize-control-"+t).show():e[t].value===o&&i("#customize-control-"+t).show()};e(),a.bind(e)}),wp.customize("wpopal_page_404_page_enable",function(a){var e=function(){var e={wpopal_page_404_bg_image:{value:"default",equal:"="},wpopal_page_404_bg_position:{value:"default",equal:"="},wpopal_page_404_bg_repeat:{value:"default",equal:"="},wpopal_page_404_bg:{value:"default",equal:"="},wpopal_page_404_page_custom:{value:"custom",equal:"="}},o=""+a.get();for(var t in e)i("#customize-control-"+t).hide(),"!="===e[t].equal?e[t].value!==o&&i("#customize-control-"+t).show():e[t].value===o&&i("#customize-control-"+t).show()};e(),a.bind(e)}),wp.customize("wpopal_header_enable_builder",function(a){var e=function(){var e={wpopal_header_builder:{value:"true",equal:"="},wpopal_header_width:{value:"true",equal:"!="},wpopal_header_layout_enable_cart_in_menu:{value:"true",equal:"!="},wpopal_header_layout_enable_search_form_in_menu:{value:"true",equal:"!="}},o=""+a.get();for(var t in e)i("#customize-control-"+t).hide(),"!="===e[t].equal?e[t].value!==o&&i("#customize-control-"+t).show():e[t].value===o&&i("#customize-control-"+t).show()};e(),a.bind(e)}),wp.customize("wpopal_header_layout_is_sticky",function(a){var e=function(){var e={wpopal_header_layout_sticky_layout:{value:"true",equal:"="},wpopal_header_layout_sticky_full_width:{value:"true",equal:"="}},o=""+a.get();for(var t in e)i("#customize-control-"+t).hide(),"!="===e[t].equal?e[t].value!==o&&i("#customize-control-"+t).show():e[t].value===o&&i("#customize-control-"+t).show()};e(),a.bind(e)}),wp.customize("wpopal_header_layout_enable_side_header",function(a){var e=function(){var e={wpopal_header_layout_side_header_position:{value:"true",equal:"="},wpopal_header_layout_side_header_width:{value:"true",equal:"="}},o=""+a.get();for(var t in e)i("#customize-control-"+t).hide(),"!="===e[t].equal?e[t].value!==o&&i("#customize-control-"+t).show():e[t].value===o&&i("#customize-control-"+t).show()};e(),a.bind(e)}),wp.customize("wpopal_footer_layout",function(a){var e=function(){var e={wpopal_footer_copyright:{value:"0",equal:"="}},o=""+a.get();for(var t in e)i("#customize-control-"+t).hide(),"!="===e[t].equal?e[t].value!==o&&i("#customize-control-"+t).show():e[t].value===o&&i("#customize-control-"+t).show()};e(),a.bind(e)}),wp.customize("wpopal_blog_single_layout",function(a){var e=function(){var e={wpopal_blog_single_sidebar:{value:"1c",equal:"!="},wpopal_blog_single_sidebar_width:{value:"1c",equal:"!="}},o=""+a.get();for(var t in e)i("#customize-control-"+t).hide(),"!="===e[t].equal?e[t].value!==o&&i("#customize-control-"+t).show():e[t].value===o&&i("#customize-control-"+t).show()};e(),a.bind(e)}),wp.customize("wpopal_woocommerce_archive_layout",function(a){var e=function(){var e={wpopal_woocommerce_archive_sidebar:{value:"1c",equal:"!="},wpopal_woocommerce_archive_sidebar_width:{value:"1c",equal:"!="}},o=""+a.get();for(var t in e)i("#customize-control-"+t).hide(),"!="===e[t].equal?e[t].value!==o&&i("#customize-control-"+t).show():e[t].value===o&&i("#customize-control-"+t).show()};e(),a.bind(e)}),wp.customize("wpopal_woocommerce_single_layout",function(a){var e=function(){var e={wpopal_woocommerce_single_sidebar:{value:"1c",equal:"!="},wpopal_woocommerce_single_sidebar_width:{value:"1c",equal:"!="}},o=""+a.get();for(var t in e)i("#customize-control-"+t).hide(),"!="===e[t].equal?e[t].value!==o&&i("#customize-control-"+t).show():e[t].value===o&&i("#customize-control-"+t).show()};e(),a.bind(e)}),wp.customize("wpopal_woocommerce_product_color_custom_enable",function(a){var e=function(){var e={wpopal_woocommerce_product_color_heading_add_to_cart:{value:"true",equal:"="},wpopal_woocommerce_product_color_add_to_cart:{value:"true",equal:"="},wpopal_woocommerce_product_color_bg_add_to_cart:{value:"true",equal:"="},wpopal_woocommerce_product_color_border_add_to_cart:{value:"true",equal:"="},wpopal_woocommerce_product_color_add_to_cart_hover:{value:"true",equal:"="},wpopal_woocommerce_product_color_bg_add_to_cart_hover:{value:"true",equal:"="},wpopal_woocommerce_product_color_border_add_to_cart_hover:{value:"true",equal:"="},wpopal_woocommerce_product_color_heading_quick_view:{value:"true",equal:"="},wpopal_woocommerce_product_color_quick_view:{value:"true",equal:"="},wpopal_woocommerce_product_color_bg_quick_view:{value:"true",equal:"="},wpopal_woocommerce_product_color_border_quick_view:{value:"true",equal:"="},wpopal_woocommerce_product_color_quick_view_hover:{value:"true",equal:"="},wpopal_woocommerce_product_color_bg_quick_view_hover:{value:"true",equal:"="},wpopal_woocommerce_product_color_border_quick_view_hover:{value:"true",equal:"="},wpopal_woocommerce_product_color_heading_wish_list:{value:"true",equal:"="},wpopal_woocommerce_product_color_wish_list:{value:"true",equal:"="},wpopal_woocommerce_product_color_bg_wish_list:{value:"true",equal:"="},wpopal_woocommerce_product_color_border_wish_list:{value:"true",equal:"="},wpopal_woocommerce_product_color_wish_list_hover:{value:"true",equal:"="},wpopal_woocommerce_product_color_bg_wish_list_hover:{value:"true",equal:"="},wpopal_woocommerce_product_color_border_wish_list_hover:{value:"true",equal:"="},wpopal_woocommerce_product_color_heading_compare:{value:"true",equal:"="},wpopal_woocommerce_product_color_compare:{value:"true",equal:"="},wpopal_woocommerce_product_color_bg_compare:{value:"true",equal:"="},wpopal_woocommerce_product_color_border_compare:{value:"true",equal:"="},wpopal_woocommerce_product_color_compare_hover:{value:"true",equal:"="},wpopal_woocommerce_product_color_bg_compare_hover:{value:"true",equal:"="},wpopal_woocommerce_product_color_border_compare_hover:{value:"true",equal:"="},wpopal_woocommerce_product_color_heading_label_sale:{value:"true",equal:"="},wpopal_woocommerce_product_color_label_sale:{value:"true",equal:"="},wpopal_woocommerce_product_color_bg_label_sale:{value:"true",equal:"="},wpopal_woocommerce_product_color_border_label_sale:{value:"true",equal:"="}},o=""+a.get();for(var t in e)i("#customize-control-"+t).hide(),"!="===e[t].equal?e[t].value!==o&&i("#customize-control-"+t).show():e[t].value===o&&i("#customize-control-"+t).show()};e(),a.bind(e)}),wp.customize("wpopal_property_archive_layout",function(a){var e=function(){var e={wpopal_property_archive_sidebar_heading_label:{value:"1c",equal:"!="},wpopal_property_archive_sidebar:{value:"1c",equal:"!="},wpopal_property_archive_sidebar_width:{value:"1c",equal:"!="}},o=""+a.get();for(var t in e)i("#customize-control-"+t).hide(),"!="===e[t].equal?e[t].value!==o&&i("#customize-control-"+t).show():e[t].value===o&&i("#customize-control-"+t).show()};e(),a.bind(e)}),wp.customize("wpopal_property_single_layout",function(a){var e=function(){var e={wpopal_property_single_sidebar_heading_label:{value:"1c",equal:"!="},wpopal_property_single_sidebar:{value:"1c",equal:"!="},wpopal_property_single_sidebar_width:{value:"1c",equal:"!="}},o=""+a.get();for(var t in e)i("#customize-control-"+t).hide(),"!="===e[t].equal?e[t].value!==o&&i("#customize-control-"+t).show():e[t].value===o&&i("#customize-control-"+t).show()};e(),a.bind(e)})}),i(window).ready(function(){i("textarea.wp-editor-area").each(function(){var o,t,e=i(this),a=e.attr("id"),l=i('input[data-customize-setting-link="'+a+'"]'),r=tinyMCE.get(a);r&&r.on("change",function(e){r.save(),t=r.getContent(),clearTimeout(o),o=setTimeout(function(){l.val(t).trigger("change")},500)}),e.css("visibility","visible").on("keyup",function(){t=e.val(),clearTimeout(o),o=setTimeout(function(){l.val(t).trigger("change")},500)})})});var t=function(){function e(){var t=this;_classCallCheck(this,e),this.container="[wpopal-font-style-control]",this.italic=".wpopal-italic",this.fontWeight=".wpopal-font-weight",this.underline=".wpopal-underline",this.uppercase=".wpopal-uppercase",i("#customize-theme-controls "+this.container).each(function(e,o){i(t.italic+", "+t.fontWeight+", "+t.underline+", "+t.uppercase,o).on("change",function(e){t.setValue(i(e.currentTarget).closest(t.container))})})}return _createClass(e,[{key:"setValue",value:function(e){var o={italic:e.find(this.italic).prop("checked"),underline:e.find(this.underline).prop("checked"),fontWeight:e.find(this.fontWeight).prop("checked"),uppercase:e.find(this.uppercase).prop("checked")};r.setValue(e,o)}}]),e}(),a=function(){function e(){var a=this;_classCallCheck(this,e),this.container="[wpopal-fonts-control]",this.googleFont=".wpopal-customize-google-fonts",this.googleFontWeight=".wpopal-font-weight select",this.googleFontSubsets=".wpopal-font-subsets select",i("#customize-theme-controls "+this.container).each(function(e,o){var t=i(o);a.initSelect2(t.find(a.googleFont)),a.initFontExtend(t.find(a.googleFontWeight)),a.initFontExtend(t.find(a.googleFontSubsets))})}return _createClass(e,[{key:"initFontExtend",value:function(e){var o=this;e.val(e.data("value")),e.on("change",function(){o.setValue(e.closest(o.container))})}},{key:"initSelect2",value:function(e){var o=this;this.initFontStyleHtml(e),e.select2_custom({templateResult:this.renderTemplate,templateSelection:this.renderTemplate}).on("change",function(){o.initFontStyleHtml(e),o.setValue(e.closest(o.container))})}},{key:"setValue",value:function(e){var o={family:e.find(this.googleFont+" option:selected").attr("value"),subsets:e.find(this.googleFontSubsets+" option:selected").attr("value"),fontWeight:e.find(this.googleFontWeight+" option:selected").attr("value")};r.setValue(e,o)}},{key:"initFontStyleHtml",value:function(e){var o=e.closest(this.container),t=e.children("option:selected").data("info"),a="",l="";if("object"===(void 0===t?"undefined":_typeof(t))){if(t.variants){a+='<option value="400">400</option>';var r=!0,u=!1,i=void 0;try{for(var c,n=t.variants[Symbol.iterator]();!(r=(c=n.next()).done);r=!0){var s=c.value;a+='<option value="'+s+'">'+s+"</option>"}}catch(e){u=!0,i=e}finally{try{!r&&n.return&&n.return()}finally{if(u)throw i}}}if(t.subsets){var _=!0,p=!1,v=void 0;try{for(var d,w=t.subsets[Symbol.iterator]();!(_=(d=w.next()).done);_=!0){var m=d.value;l+='<option value="'+m+'">'+m+"</option>"}}catch(e){p=!0,v=e}finally{try{!_&&w.return&&w.return()}finally{if(p)throw v}}}}o.find(".wpopal-font-weight select").html(a),o.find(".wpopal-font-subsets select").html(l)}},{key:"renderTemplate",value:function(e){if(!e.id)return e.text;var o=e.id.toLocaleLowerCase().replace(/\s+/,"-");return i("<span>"+e.text+'</span><span class="wpopal-font '+o+'"></span>')}}]),e}(),l=function(){function e(){var l=this;_classCallCheck(this,e),this.container="[wpopal-select-image-control]",this.listImage=".select-list-image",this.settingId="",this.$container="",this.createImageSelectLayout(),i("body").on("click",function(e){i(e.currentTarget).hasClass("changing-image")&&l.closePanel()}),i("#customize-theme-controls "+this.container+" "+this.listImage+" li").on("click",function(e){var o=i(e.currentTarget);if(!o.hasClass("active")){var t=o.closest(l.listImage),a=o.closest(l.container);t.children("li").removeClass("active"),o.addClass("active"),r.setValue(a,o.find("img").attr("alt"))}}),i(document).on("click",".button-change-image",function(e){e.preventDefault();var o=i("body");if(o.hasClass("changing-image"))l.closePanel();else{l.$container=i(e.currentTarget).closest(".opal-control-image-select");var t=l.$container.children(".image-select").html();l.settingId=l.$container.data("id"),l.setPanelContent(t.trim()),o.addClass("changing-image")}}).on("click",".image-select-tpl",function(e){e.stopPropagation();var o=i(e.currentTarget);if(!o.hasClass("active")&&l.$container){var t=i("#customize-control-"+l.settingId),a=o.children("img").attr("alt");t.find(".image-select-tpl").removeClass("active"),t.find('.image-select-tpl[data-value="'+a+'"]').addClass("active"),r.setValue(l.$container,a)}l.closePanel()})}return _createClass(e,[{key:"createImageSelectLayout",value:function(){i("body .wp-full-overlay").append('<div id="select-image-left">\x3c!-- compatibility with JS which looks for widget templates here --\x3e\n    <div id="available-select-image">\n        <div id="available-images-list">\n                \n        </div>\x3c!-- #available-images-list --\x3e\n    </div>\x3c!-- #available-select-image --\x3e\n</div>')}},{key:"setPanelContent",value:function(e){i("#available-images-list").html(e)}},{key:"closePanel",value:function(){i("body").removeClass("changing-image")}}]),e}();i(document).ready(function(){i(".wpopal-select-group-button").each(function(e,o){var t=i(o),a=t.find(">select"),l=t.find(">.button"),r=a.val();if(""!==r){var u=t.find('option[value="'+r+'"]').data("id");u&&(l.attr("href",l.data("link")+"&post="+u),l.show())}})});var u=function(){function e(){_classCallCheck(this,e),this.container="#wpopal-customize-quick-search",0<i("#customize-header-actions").length&&this.init()}return _createClass(e,[{key:"init",value:function(){}},{key:"renderHtml",value:function(){return'<div id="'+this.container.replace("#","")+'">\n    <input class="search-for" type="text" value="" placeholder="Search...">\n    <div class="search-results hidden"></div>\n</div>'}}]),e}(),c=function e(){_classCallCheck(this,e),i("#customize-theme-controls .wpopal-switch-sidebar").on("change",function(e){var o=i(e.currentTarget).next().find("button");console.log(o),o.attr("data-id","sidebar-widgets-"+e.currentTarget.value)})},n=function(){function e(){var t=this;_classCallCheck(this,e),i(".wpopal-customize-slider .wpopal-slider").each(function(e,o){t.initSlider(o)})}return _createClass(e,[{key:"initSlider",value:function(e){var t=i(e),a=t.data("id"),l=t.data("unit")?t.data("unit"):"";t.slider({range:"min",min:t.data("min"),max:t.data("max"),step:t.data("step"),value:t.data("value"),create:function(e,o){t.children(".ui-slider-handle").html("<span>"+t.slider("value")+l+"</span>")},slide:function(e,o){t.children(".ui-slider-handle").html("<span>"+o.value+l+"</span>"),wp.customize.control(a).setting.set(o.value)},change:function(e,o){t.children(".ui-slider-handle").html("<span>"+o.value+l+"</span>"),wp.customize.control(a).setting.set(o.value)}}),t.parent().find(".wpopal-reset").on("click",function(){t.slider("value",t.data("default-value"))}),t.parent().find(".wpopal-remove").on("click",function(){t.slider("value","")})}}]),e}();i(document).ready(function(){new o,new n,new a,new t,new l,new e,new u,new c,wp.customize.previewer.bind("refresh-frame",function(){wp.customize.previewer.refresh()}),wp.customize.previewer.bind("opal-save-and-reload",function(){wp.customize.previewer.save().then(function(){wp.customize.previewer.refresh();var e=i("#customize-preview iframe").get(0);e.src=e.src})})}),wp.customize.bind("ready",function(){var e=["wpopal_product_images","wpopal_product_comment_template","wpopal_product_tabs","wpopal_product_layout"];wp.customize("wpopal_product_layout_style",function(a){a.bind(function(e){o(e)});var o=function(t){i(e).each(function(e,o){wp.customize.control(o,function(e){var o=function(){"custom"===t?e.container.show():e.container.hide()};o(),a.bind(o)})})};o(a.get())})})}(jQuery,wp.customize);