(function () {
    "use strict";

    var assetsObj = '%replace(assetsObj)%',
        assets,
        assetsLen,
        assetsItem,
        resource = { },
        resourceItem,
        renewNames = [],
        addRenewNames = function (val) { renewNames.push(val);},

        xhr,

        i = 0,
        order = {
            frontend: ['appcss', 'commonjs', 'appjs'],
            management: []
        },
        orderItem,
        el
        ;

    // have some error
    typeof assetsObj !== 'object' && location.reload();

    // support localStorage
    if (typeof localStorage === 'object') {
        assets = assetsObj.assets;
        assetsLen = assets.length;

        for (; assetsLen--;) {
            assetsItem = assets[assetsLen];                                    // { name: 'xx', hash: 'hex' }

            resourceItem = localStorage.getItem(assetsItem.name);              // json or null

            if (resourceItem) {
                try {
                    resourceItem = JSON.parse(resourceItem);                   // { value: 'xx', hash: 'hex' }

                    // undefined will throw error
                    resourceItem.value.split;
                    resourceItem.hash.split;

                    if (resourceItem.hash === assetsItem.hash) {
                        resource[assetsItem.name] = resourceItem.value;        // { appcss: 'xx', commonjs: 'xx' }
                    }
                    else {
                        addRenewNames(assetsItem.name);
                    }
                }
                catch (err) {
                   addRenewNames(assetsItem.name);
               }
            }
            else {
                addRenewNames(assetsItem.name);
            }
        }

        // get new assets
        if (renewNames.length !== 0) {
            if (assetsObj.cdn) {

                // TODO get from CDN
            }
            else {

                // TODO 未实现 IE 9 下跨域兼容
                xhr = new XMLHttpRequest();
                xhr.open('GET', 'http://192.168.1.54/bigger-blog/public/blog');
                xhr.addEventListener('readystatechange', function (e) {
                    e = e.target;

                    if (e.readyState == 4 && e.status == 200) {
                        var json = e.responseText;

                        console.log(e);
                    }
                });
                xhr.send();
            }
        }

        // exec
        order = order[assetsObj.type];                                         // Array
        for (; i < order.length; i++) {
            orderItem = order[i];                                              // String

            el = document.createElement(orderItem.substr(-2, 2) === 'ss' ? 'style' : 'script');
            el.innerText = resource[orderItem] || '';                          // String, undefined is trouble
            document.head.appendChild(el);
        }
    }

    // do not support localStorage
    else {

        // TODO set cookie
        location.reload();
    }
})();