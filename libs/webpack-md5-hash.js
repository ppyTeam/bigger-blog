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

const getHashDigest = require('loader-utils').getHashDigest,
    writeFileSync = require('fs').writeFileSync,
    hashJSONFile = require('path').join(__dirname, '..', 'storage', 'app', 'assets-hash.json');

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
      let hashObj = {
        frontend: { },
        management: { }
      };

      for (let key in assets) {
        if (key !== 'extract-text-webpack-plugin-output-filename') {
          let keyArr = key.split(/[-.\/]/),
              type = /^common$|^app$/.test(keyArr[1]) ? 'frontend' : 'management';

          hashObj[type][keyArr[1] + keyArr[0]] = {
            filename: key,
            hash: keyArr[2]
          };
        }
      }

      let count = 0;
      for (let key in hashObj.frontend) count++;
      for (let key in hashObj.management) count++;
      count && writeFileSync(hashJSONFile, JSON.stringify(hashObj));
    });
  });
};

module.exports = WebpackMd5Hash;