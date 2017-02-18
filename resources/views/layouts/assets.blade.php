@section('mobile-header')
    @if ($is_mobile)
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
            host: '{{ $assets['url'] }}',
            type: '{{$type}}',
            assets: {
            @foreach ($assets[$type] as $assets_key => $each_assets )
            {{ $assets_key }}: { hash: '{{$each_assets['hash']}}', url: '{{$each_assets['filename']}}' },
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
    @else
        <link href="{{ $assets['url'].$assets['frontend']['appcss']['filename'] }}" rel="stylesheet">
    @endif
@endsection

@section('mobile-body')
    @if ($is_mobile)
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
    @else
        <script src="{{ $assets['url'] . $assets['frontend']['commonjs']['filename'] }}"></script>
        <script src="{{ $assets['url'] . $assets['frontend']['appjs']['filename'] }}"></script>
    @endif
@endsection

{{-- 直接输出到前端的 JavaScript Object --}}
@section('common-data')
<script type="text/javascript">
// 导航数据
window.navData = {
    main_link: '/blog',
    title: '我要搞一个大标题',
    subtitle: '副标题的长度最大是十四个汉字',
    logo_url: 'http://www.ciyuanjie.cn/wp-content/uploads/2016/12/%E3%80%90%E5%A4%B4%E5%83%8F%E3%80%91%E5%8F%88%E6%98%AF%E5%A5%97%E8%B7%AF-%E8%B6%85%E5%A4%9A%E5%8F%AF%E8%BE%BE%E9%B8%AD%E5%A4%B4%E5%83%8F%E8%87%AA%E9%80%89-4.jpg',
    banner_url: null, // 'http://tva3.sinaimg.cn/crop.702.310.825.825.180/ed454aefgw1ecovuunw9pj21kw16o7wh.jpg',
    posts_count: 110,
    categories_count: 8,
    tags_count: 68,
    nav: [ // flag 为 true 时为站内链接，使用 SPA，否则为站外链接
        @foreach($nav['nav'] as $eachNav)
        { url: '{{ $eachNav['url'] }}', name: '{{ $eachNav['name'] }}', flag: {{ $eachNav['flag'] }}  },
        @endforeach
    ],
    socially: [ // name 是相关名称，鼠标悬停时显示，icon 为 CSS 字体的后半部分
        @foreach($nav['socially'] as $eachNav)
        { url: '{{ $eachNav['url'] }}', name: '{{ $eachNav['name'] }}', icon: '{{ $eachNav['icon'] }}' },
        @endforeach
    ]
}
</script>
@endsection