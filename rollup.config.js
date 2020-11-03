// import {terser} from 'rollup-plugin-terser';
import resolve from '@rollup/plugin-node-resolve';
import commonjs from '@rollup/plugin-commonjs';
import { injectManifest } from 'rollup-plugin-workbox';
import copy from 'rollup-plugin-copy';
import {terser} from 'rollup-plugin-terser';

const isProduction = process.env.NODE_ENV === 'production';

const sass = (files,outputPath) => {
      return {
        name: 'copy',
        ['buildEnd']: async () =>{
          
          const sassCSS = require('node-sass');
          const fs = require('fs');
          files.forEach(sassFile => {
            sassCSS.render({
                file:sassFile,
                outFile: outputPath,
              }, async function(error, result) { // node-style callback from v3.0.0 onwards
                if(!error){
                  // No errors during the compilation, write this result on the disk
                  const cssFile = sassFile.replace('.sass','.css').substr(sassFile.lastIndexOf('/')+1);
                  await fs.writeFile(`./${outputPath}/${cssFile}`, result.css, function(err){
                    if(!err){
                      console.log(`${cssFile} written to disk`);
                    } else {
                      console.log(err);
                    }
                  });
                } else{
                  console.log(error);
                }
              });
          });
        }
      }
      
    }


export default [{
    input: 'resources/js/app.js',
    plugins: [
      sass(['resources/css/app.sass'],'public/css'),
      copy({
        targets: [
          { src: 'resources/manifest.webmanifest', dest: 'public' },
          { src: 'resources/img/**/*', dest: 'public/img' }
        ]
      }),
      resolve({
        browser:true,
        moduleDirectory: 'node_modules'
      }),
      commonjs({
        include: 'node_modules/**'
      }),
      isProduction && terser(),
      injectManifest({
        swSrc: 'resources/js/service-worker.js',
        swDest: 'public/service-worker.js',
        mode: 'production',
        globDirectory: 'public/',
        globPatterns: [
            //'\*\*/\*.{html,js,css}',
            '\*\*/app.js',
            '\*\*/app.css'
            ]
        })
    ],
    output: {
      file: 'public/js/app.js',
      format: 'esm'
    }
  }, {
    input: 'resources/js/infinite-scroll.js',
    output: {
      file: 'public/js/infinite-scroll.js',
      format: 'esm',
      plugins: [
        isProduction && terser()
      ]
    }
  }, {
    input: 'resources/js/intersection-observer.js',
    output: {
      file: 'public/js/intersection-observer.js',
      format: 'iife',
      plugins: [
        isProduction && terser()
      ]
    }
  }, {
    input: 'resources/js/timeline.js',
    output: {
      file: 'public/js/timeline.js',
      format: 'iife',
      plugins: [
        isProduction && terser()
      ]
    }
  },{
    input: 'resources/js/helper.js',
    output: {
      file: 'public/js/helper.js',
      format: 'esm',
      plugins: [
        isProduction && terser()
      ]
    }
  },{
    input: 'resources/js/create-link.js',
    output: {
      file: 'public/js/create-link.js',
      format: 'iife',
      plugins: [
        isProduction && terser()
      ]
    }
  }];