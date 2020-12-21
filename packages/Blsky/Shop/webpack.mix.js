const mix = require("laravel-mix");
require('mix-env-file');
mix.env(process.env.ENV_FILE);

if (mix == 'undefined') {
    const { mix } = require("laravel-mix");
}

require("laravel-mix-merge-manifest");

if (mix.inProduction()) {
    var publicPath = 'publishable/assets';
} else {
    var publicPath = "../../../../public_html/"+process.env.APP_NAME+"/themes/blsky/assets";
}

mix.setPublicPath(publicPath).mergeManifest();
mix.disableNotifications();



mix.options({ processCssUrls: false })
    .js([__dirname + "/src/Resources/assets/js/app.js"], publicPath + "js/shop.js")
    .copyDirectory(__dirname + "/publishable/assets/images", publicPath + "/images")
    .sass(__dirname + "/src/Resources/assets/sass/app.scss", publicPath + "/css/shop.css")
    .sass(__dirname + "/src/Resources/assets/sass/bootstrap.scss", publicPath + "/css/bootstrap.css")
    .sass(__dirname + "/src/Resources/assets/sass/custom.scss", publicPath + "/css/custom.css")
    .options({
        processCssUrls: false
    });

if (!mix.inProduction()) {
    mix.sourceMaps();
}

if (mix.inProduction()) {
    mix.version();
}
