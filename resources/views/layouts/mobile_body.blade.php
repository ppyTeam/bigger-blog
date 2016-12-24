<script type="text/javascript">
    (function () {
        "use strict";

        var assets = window.assetsData.assets,
            tmpAssetsItem, tmpAssetsItemName, lsItem,

            renewNames = [],
            addRenewNames = function (name, isRemove) {
                isRemove && localStorage.removeItem(name);

                renewNames.push(name);
            },

            i = 0,
            responseCount = 0,
            renewNamesLen;

        for (tmpAssetsItemName in assets) {
            tmpAssetsItem = assets[tmpAssetsItemName];                       // { hash: 'hex', url: 'xx' }

            lsItem = localStorage.getItem(tmpAssetsItemName);                // json or null

            if (lsItem) {
                try {
                    lsItem = JSON.parse(lsItem);                             // { value: 'xx', hash: 'hex' }

                    // undefined will throw error
                    lsItem.value.split;
                    lsItem.hash.split;

                    if (lsItem.hash === tmpAssetsItem.hash) {
                        window.finAssets[tmpAssetsItemName] = lsItem.value;  // { appcss: 'xx', commonjs: 'xx' }
                    }
                    else {
                        addRenewNames(tmpAssetsItemName, true);
                    }
                }
                catch (e) {
                    addRenewNames(tmpAssetsItemName, true);
                }
            }
            else {
                addRenewNames(tmpAssetsItemName);
            }

            lsItem = undefined;
        }

        // update LocalStorage
        renewNamesLen = renewNames.length;
        if (renewNamesLen !== 0) {
            for (; i < renewNamesLen; i++) {

                // closure
                (function () {
                    return function () {
                        var tmpAssetsItemName = renewNames[i],
                            tmpAssetsItemValue = assets[tmpAssetsItemName],
                            xhr = new XMLHttpRequest();

                        xhr.open('GET', window.assetsData.host + tmpAssetsItemValue.url);
                        xhr.addEventListener('readystatechange', function(e) {
                            var resObj;

                            e = e.target;
                            if (e.readyState === 4 && (e.status === 200 || e.status === 304)) {
                                resObj = {
                                    value: window.finAssets[tmpAssetsItemName] = e.responseText, // <- 赋值
                                    hash: tmpAssetsItemValue.hash
                                };

                                // insert into LocalStorage
                                try {

                                    // QUOTA_EXCEEDED_ERR (Safari bugs or quota is full)
                                    localStorage.setItem(tmpAssetsItemName, JSON.stringify(resObj));
                                }
                                catch (e) { }

                                ++responseCount === renewNamesLen && window.LStoHTML();
                            }
                        });
                        xhr.send();
                    }
                })()();
            }
        }
        else {
            window.LStoHTML();
        }
    })();
</script>