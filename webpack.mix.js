const mix = require('laravel-mix');

mix
  .js('resources/js/app.js', 'public/js/app.js')
  .react()
  .disableSuccessNotifications();

if (mix.inProduction()) {
  mix.sourceMaps().version();
}
