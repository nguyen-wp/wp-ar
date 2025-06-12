"use strict";

(function () {
  tinymce.PluginManager.add('madelab_mce_dropbuttonshortcodes', function (editor, url) {
    editor.addButton('madelab_mce_dropbuttonshortcodes', {
      text: 'MADE Shortcodes',
      type: 'menubutton',
      menu: [{
        text: '[made_add_to_calendar]',
        onclick: function onclick() {
          editor.insertContent('[made_add_to_calendar date_1="2022-10-01" date_2="2022-10-02" date_3="2022-10-03" time_start_1="09:00" time_end_1="17:00" time_start_2="09:00" time_end_2="17:00" time_start_3="09:00" time_end_3="17:00" title_1="Event Title" description_1="Event Description" location_1="501 E Broadway Ave, Fort Worth, TX 76104" title_2="Event Title" description_2="Event Description" location_2="501 E Broadway Ave, Fort Worth, TX 76104" title_3="Event Title" description_3="Event Description" location_3="501 E Broadway Ave, Fort Worth, TX 76104" label="Add to calendar" url="http://www.example.com"]');
        }
      }, {
        text: '[made_forgot]',
        onclick: function onclick() {
          editor.insertContent('[made_forgot refirect="https://abc.com"]');
        }
      }, {
        text: '[made_register]',
        onclick: function onclick() {
          editor.insertContent('[made_register refirect="https://abc.com"]');
        }
      }, {
        text: '[made_login]',
        onclick: function onclick() {
          editor.insertContent('[made_login refirect="https://abc.com"]');
        }
      }, {
        text: '[made_logout]',
        onclick: function onclick() {
          editor.insertContent('[made_logout refirect="https://abc.com"]');
        }
      }, {
        text: '[made_recent_posts]',
        onclick: function onclick() {
          editor.insertContent('[made_recent_posts type="recent" post_type="post" per_page="5" orderby="rand" order="desc"]');
        }
      }, {
        text: '[made_recent_products]',
        onclick: function onclick() {
          editor.insertContent('[made_recent_products per_page="5" orderby="rand" order="desc"]');
        }
      }, {
        text: '[made_featured_products]',
        onclick: function onclick() {
          editor.insertContent('[made_featured_products per_page="5" orderby="rand" order="desc"]');
        }
      }, {
        text: '[made_top_rated_products]',
        onclick: function onclick() {
          editor.insertContent('[made_top_rated_products per_page="5" orderby="rand" order="desc"]');
        }
      }, {
        text: '[made_sale_products]',
        onclick: function onclick() {
          editor.insertContent('[made_sale_products per_page="5" orderby="rand" order="desc"]');
        }
      }, {
        text: '[made_best_selling_products]',
        onclick: function onclick() {
          editor.insertContent('[made_best_selling_products per_page="5" orderby="rand" order="desc"]');
        }
      }, {
        text: '[made_faqs]',
        onclick: function onclick() {
          editor.insertContent('[made_faqs]');
        }
      }, {
        text: '[made_instagram]',
        onclick: function onclick() {
          editor.insertContent('[made_instagram]');
        }
      }, {
        text: '[made_block]',
        onclick: function onclick() {
          editor.insertContent('[made_block id="abc"]');
        }
      }, {
        text: '[made_slider]',
        onclick: function onclick() {
          editor.insertContent('[made_slider id="abc"]');
        }
      }, {
        text: '[made_asset]',
        onclick: function onclick() {
          editor.insertContent('[made_asset id="abc"]');
        }
      }, {
        text: '[made_sponsor]',
        onclick: function onclick() {
          editor.insertContent('[made_sponsor id="abc"]');
        }
      }]
    });
  });
})();