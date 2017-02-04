const PATH = require('path'),
    Webpack = require('webpack'),
    ExtractTextPlugin = require('extract-text-webpack-plugin'),
    CleanWebpackPlugin = require('clean-webpack-plugin'),
    WebpackMd5Hash = require(PATH.join(__dirname, 'libs', 'webpack-md5-hash.js'));

const PROD = process.env.NODE_ENV === 'production',
    RES_PATH = PATH.join(__dirname, 'resources'),
    PUB_PATH = PATH.join(__dirname, 'public');


module.exports = {
  devtool: PROD ? false : '#cheap-module-eval-source-map',


  entry: {
    // DO NOT change key name
    common: ['vue', 'vue-router', 'vue-resource', 'vuex', 'nprogress', 'highlight.js'],
    app: PATH.join(RES_PATH, 'assets', 'js', 'app.js') // ./resources/assets/js/app.js
  },


  output: {
    path: PUB_PATH,
    publicPath: '/',
    filename: PATH.join('js', '[name]-[chunkhash:8].js')
  },


  resolve: {
    alias: {
      'vue$': 'vue/dist/vue.common.js',
      // style: './less',
      // plugins: './plugins',
      // // 别名可以是路径或文件
      // // 排除要打包的文件后，可以使用别名进行优化，方便更快地找到文件，再用 module.noParse 使其更快速构建
    },

    // 自动补全扩展名
    extensions: [
      '.scss',
      '.vue',
      '.js'
    ],

    modules: [
      PATH.resolve('node_modules')
    ]
  },


  module: {
    // noParse: [path.join(__dirname, '/public/assets/js/xxx')],
    rules: [
  //     {
  //       test: /\.json$/,
  //       loader: "json"
  //     },

      {
        test: /\.js$/,
        exclude: /node_modules/,
        loader: 'babel-loader'
      },

      {
        test: /\.vue$/,
        exclude: /node_modules/,
        loader: 'vue-loader',
        options: {
          loaders: {
            css: ExtractTextPlugin.extract({
              fallbackLoader: 'vue-style-loader',
              loader: [
                'css-loader',
                'postcss-loader'
              ]
            }),
            scss: ExtractTextPlugin.extract({
              fallbackLoader: 'vue-style-loader',
              loader: [
                'css-loader',
                'postcss-loader',
                'sass-loader'
              ]
            }),
          }
        }
      },

      {
        test: /\.css$/,
        loader: ExtractTextPlugin.extract({
          fallbackLoader: "style-loader",
          loader: [
            'css-loader',
            'postcss-loader'
          ]
        })
      },

      {
        test: /\.scss$/,
        loader: ExtractTextPlugin.extract({
          fallbackLoader: 'style-loader',
          loader: [
            'css-loader',
            'postcss-loader',
            'sass-loader'
          ]
        })
      },

      {
        test: /\.(woff|woff2|eot|ttf|otf)$/i,
        loader: 'url-loader',
        query: {
          limit: 8192,
          name: 'fonts/[name].[ext]'
        }
      },

      {
        // 把所有图片打包到文件中，base64
        test: /\.(jpe?g|png|gif|svg)$/i,
        loader: 'url-loader',
        query: {
          limit: 8192,
          name: 'images/[name].[ext]'
        }
      },

  //     {
  //       // 暴露出口
  //       test: require.resolve("jquery"),
  //       loader: "expose?$!expose?jQuery"
  //       // 可以与 exports-loader 和 imports-loader 结合使用
  //     }
    ]
  },


  plugins: [

    // loader选项
    new Webpack.LoaderOptionsPlugin({
      minimize: true,
      options: {
        postcss: [
          require('autoprefixer')({
            // https://github.com/postcss/autoprefixer
            remove: false,
            browsers: ['> 5%']
          })
        ]
      }
    }),

    // 清理发布文件夹
    new CleanWebpackPlugin([
      PATH.join(PUB_PATH, 'js'),
      PATH.join(PUB_PATH, 'css'),
      PATH.join(PUB_PATH, 'images')
    ], {
      // root: './',
      // verbose: false,
      // dry: false,
      // exclude: []
    }),

    // 输出的文件的版权信息
    // new Webpack.BannerPlugin("Copyright ttionya inc."),

    // 提取公共模块
    new Webpack.optimize.CommonsChunkPlugin({
      name: 'common',
      filename: PATH.join('js', 'common-[chunkhash:8].js'),
      minChunks: Infinity
    }),

    // 提取CSS
    new ExtractTextPlugin({
      filename: PATH.join('css', '[name]-[contenthash:8].css'),
      disable: false,
      allChunks: true
    }),

    // MD5 plugins, edit by ttionya
    new WebpackMd5Hash(),

    // Uglify
    PROD ?
        new Webpack.optimize.UglifyJsPlugin({
          compress: {
            warnings: false
          }
        })
        : () => {},


  //   // 作为全局变量插入到所有的代码中，可以直接在页面中使用
  //   new Webpack.ProvidePlugin({
  //     $: 'jquery',
  //     jQuery: 'jquery',
  //     'window.jQuery': 'jquery'
  //   }),
  ],


  // hidden WARNING
  performance: {
    hints: false
  },

  // 排除不需要打包的包，此时需要使用<script>标签引入
  // externals: {
  //   jquery: 'window.jQuery',
  //   react: 'window.React',
  // },
};