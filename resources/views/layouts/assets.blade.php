@section('mobile-header')
<script type="text/javascript">
    (function () {
        "use strict";

        // test LocalStorage
        try {
            localStorage.setItem('_test', 0);
            localStorage.removeItem('_test');
        }
        catch (e) {

            // set cookie
            var date = new Date();
            date.setTime(date.getTime() + 31536000000);
            document.cookie = 'nols=1; path=/; expires=' + date.toUTCString + '; max-age=31536000';

            location.reload();
        }

        window.assetsData ={
            host: '{{ $res['assets-hash']['host'] }}/',
            type: '{{ $res['assets-hash']['type'] }}',
            assets: {
            @foreach ($res['assets-hash']['assets'] as $assets_key => $each_assets )
            {{ $assets_key }}: { hash: '{{$each_assets['hash']}}', url: '{{$each_assets['url']}}' },
            @endforeach
            }
        };
        typeof assetsData !== 'object' && location.reload();

        window.finAssets = { };
        window.LStoHTML = function () {
            var order = {
                    frontend: ['appcss', 'commonjs', 'appjs'],
                    management: []
                },
                i = 0,
                d = document,
                tmpOrderItem, el,
                dHead = d.head, dBody = d.body;

            order = order[window.assetsData.type];                         // Array
            for (; i < order.length; i++) {
                tmpOrderItem = order[i];                                   // String

                if (tmpOrderItem.substr(-2, 2) === 'ss') {
                    el = d.createElement('style');
                    el.type = 'text/css';
                    el.innerText = window.finAssets[tmpOrderItem] || '';   // String, undefined is trouble
                    dHead.appendChild(el);
                }
                else {
                    el = d.createElement('script');
                    el.type = 'text/javascript';
                    el.innerText = finAssets[tmpOrderItem] || '';          // String, undefined is trouble
                    dBody.appendChild(el);
                }
            }
        };
    })();
</script>
@endsection

@section('mobile-body')
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
@endsection