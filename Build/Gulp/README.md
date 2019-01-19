# Gulpfile.js tailored to Flow Framework and Neos CMS project

Stolen files originaly created by [jonnitto](https://github.com/jonnitto/gulpfile.js) and carefully 
packaged for your Flow Framework and Neos CMS project.

Installation
------------

    composer require --dev ttree/gulpfilejs
    
When the package is installed you can copy the templates files:

    cp -rT Build/Gulp/templates ./

**Warning**: Check the content of the ```templates``` directory to not override 
important stuffs on your distribution. Your are free to not use the provided templates 
or customize them to match your own requirements. The following document is based on the
official templates.

Edit the ```package.json``` in your distribution directory to match your requirements.

	nvm use # to enable the correct 
	yarn install
	yarn run tasks
	
You must see something like:

```
[14:14:53] Tasks for ~/Sites/dev/www.domain.dev/Build/Gulp
[14:14:53] ├── build             Generates all  Assets, Javascript and CSS files
[14:14:53] │   --b, --beautify  … Beautify and dont't compress files
[14:14:53] │   --d, --debug     … Files dont't get compressed and sourcemaps get genereated
[14:14:53] │   --m, --maps      … Write sourcemaps
[14:14:53] ├── css              Render CSS Files
[14:14:53] │   --b, --beautify  … Beautify and dont't compress files
[14:14:53] │   --d, --debug     … Files dont't get compressed and sourcemaps get genereated
[14:14:53] │   --m, --maps      … Write sourcemaps
[14:14:53] ├─┬ default           Generates all  Assets, Javascript and CSS files &  watch them
[14:14:53] │ │ --b, --beautify  … Beautify and dont't compress files
[14:14:53] │ │ --d, --debug     … Files dont't get compressed and sourcemaps get genereated
[14:14:53] │ │ --m, --maps      … Write sourcemaps
[14:14:53] │ └─┬ <series>
[14:14:53] │   ├── build
[14:14:53] │   └── watch
[14:14:53] ├── js               Render Javascript Files
[14:14:53] │   --b, --beautify  … Beautify and dont't compress files
[14:14:53] │   --d, --debug     … Files dont't get compressed and sourcemaps get genereated
[14:14:53] │   --m, --maps      … Write sourcemaps
[14:14:53] ├── jsLint           Lint Javascript files
[14:14:53] ├── optimizeImages   Optimize images and overrite them in the public folder
[14:14:53] ├─┬ pipeline         Build task for pipeline
[14:14:53] │ └─┬ <series>
[14:14:53] │   ├── build
[14:14:53] │   └── optimizeImages
[14:14:53] ├── scss             Render _all.scss and _allsub.scss Files
[14:14:53] ├── sprite           Create SVG Sprite
[14:14:53] └── watch            Watch files and regenereate them
✨  Done in 5.61s.
```

Check [jonnitto](https://github.com/jonnitto/gulpfile.js) for more details informations.

**Warning**: This package currently don't support Babel, we opt to use Bublé most of the time, maybe this can change in the future.
The original version from [jonnitto](https://github.com/jonnitto/gulpfile.js) support both Bublé (default) and Babel.

Features
--------

- [RollupJS](https://rollupjs.org/) (module bundler)
- [Bublé](https://buble.surge.sh/guide/) (the blazing fast, batteries-included ES2015 compiler)
- [PostCSS](http://postcss.org/)
- [Browsersync](https://www.browsersync.io/)
- Assets (JS/CSS) pre compression with Broetli and Zoepfli
- Gulp, Uglify, Image optimizations, SVG Sprites, ...

Configuration
-------------

You can read the default configuration in ```config.json```, if you need to override the configuration for a specific site package, 
you can create a ```Gulp.json``` in the ```Configuration``` directory, like this:

```json
{
    "root": {
        "notifications": true
    },
    "browserSync": {
        "enable": true,
        "proxy": "https://www.domain.dev:8180"
    },
    "tasks": {
        "compress": true
    }
}
```

This configuration will enable system notification, browsersync and enable global compression of static assets (JS/CSS) with Broetli and Zoepfli.

Acknowledgments
---------------

All the hard work has been done by [jonnitto](https://github.com/jonnitto/gulpfile.js)

Packaging and fork sponsored by [ttree ltd - neos solution provider](http://ttree.ch).

We try our best to craft this package with a lots of love, we are open to
sponsoring, support request, ... just contact us.

License
-------

Licensed under MIT, see [LICENSE](LICENSE)
