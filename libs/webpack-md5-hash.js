/**
 * webpack-md5-hash
 * Plugin to replace a standard webpack chunkhash with md5.
 * Copyright (c) 2015 Kirill Ermolov
 * Licensed MIT
 * https://github.com/erm0l0v/webpack-md5-hash
 * https://www.npmjs.com/package/webpack-md5-hash
 * v0.0.5
 *
 * Edit by ttionya
 */

"use strict";

const getHashDigest = require('loader-utils').getHashDigest;

let compareModules = (pre, aft) => pre.resource <= aft.resource ?  -1 : 1;

let getModuleSource = module => {
    let _source = module._source || {};
    return _source._value || '';
};

function WebpackMd5Hash () { }

WebpackMd5Hash.prototype.apply = compiler => {
  compiler.plugin("compilation", compilation => {
    compilation.plugin("chunk-hash", (chunk, chunkHash) => {

      // we provide an initialValue in case there is an empty module source. Ref: http://es5.github.io/#x15.4.4.21
      let source = chunk.modules.sort(compareModules).map(getModuleSource).reduce((result, module_source) => result + module_source, '');

      // Return different value between development and production mode.
      source += process.env.NODE_ENV || '';

      chunkHash.digest = () => getHashDigest(source);
    });

    compilation.plugin("after-optimize-assets", assets => {
      for (let key in assets) {
        if (key !== 'extract-text-webpack-plugin-output-filename') {
          // TODO
        }
      }
    });
  });
};

module.exports = WebpackMd5Hash;