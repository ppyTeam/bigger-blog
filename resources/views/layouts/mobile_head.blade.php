<script type="text/javascript">
    (function () {
        "use strict";

        // test LocalStorage
        try {
            localStorage.setItem('_test', 0);
            localStorage.removeItem('_test');
        }
        catch (e) {

            // TODO set cookie
            location.reload();
        }

        window.assetsData ={
            host: '{{ $res['assets-hash']['host'] }}',
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