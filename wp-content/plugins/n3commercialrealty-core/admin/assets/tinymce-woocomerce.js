(function () {
    tinymce.PluginManager.add('madelab_mce_dropbuttonwoocomerce', function (editor, url) {
        editor.addButton('madelab_mce_dropbuttonwoocomerce', {
            text: 'MADE Woo',
            type: 'menubutton',
            menu: [
                {
                    text: '[related_products]',
                    onclick: function () {
                        editor.insertContent('[related_products limit="12" columns="4"]');
                    }
                },
                {
                    text: '[add_to_cart id="*"]',
                    onclick: function () {
                        editor.insertContent('[add_to_cart id="90"]');
                    }
                },
                {
                    text: '[woocommerce_cart]',
                    onclick: function () {
                        editor.insertContent('[woocommerce_cart]');
                    }
                },
                {
                    text: '[woocommerce_checkout]',
                    onclick: function () {
                        editor.insertContent('[woocommerce_checkout]');
                    }
                },
                {
                    text: '[woocommerce_my_account]',
                    onclick: function () {
                        editor.insertContent('[woocommerce_my_account]');
                    }
                },
                {
                    text: '[woocommerce_order_tracking]',
                    onclick: function () {
                        editor.insertContent('[woocommerce_order_tracking]');
                    }
                },
                {
                    text: '[products]',
                    onclick: function () {
                        editor.insertContent('[products limit="4" columns="4" orderby="popularity" class="quick-sale" on_sale="true"]');
                    }
                },
                {
                    text: '[sale_products]',
                    onclick: function () {
                        editor.insertContent('[sale_products]');
                    }
                },
                {
                    text: '[featured_products]',
                    onclick: function () {
                        editor.insertContent('[featured_products]');
                    }
                },
            ]
        });
    });
})();
