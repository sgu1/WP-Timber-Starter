const path = require("path");
const webpack = require("webpack");

// Easy path access using this object
const PATHS = {
    app: path.join(__dirname, "../_resources/react/"),
    build: path.join(__dirname, '../TitanGPS/wp-content/themes/titangps/assets/js/'),
  };

module.exports = {
    entry: {
        roicalc: path.join(PATHS.app, "roi-calculator/roicalculator.js")
    },
    output: {
        filename: "[name].bundle.js",
        //path: path.join(__dirname,  "dist")
        path: PATHS.build
    },
    module:{
        rules: [
            {
                test: /\.m?js$/,
                exclude: /(node_modules|bower_components)/,
                use: {
                    loader: "babel-loader",
                    options: {
                        presets: ["@babel/preset-env", "@babel/preset-react"],
                        plugins: ["transform-class-properties"]
                    }
                }
            },
            {
                test: /\.css$/,
                use: [
                    "style-loader", // creates style nodes from JS strings
                    "css-loader", // translates CSS into CommonJS
                    "sass-loader" // compiles Sass to CSS, using Node Sass by default
                ]
            },
            {
                test: /\.scss$/,
                use: [
                    {loader: "style-loader"},
                    {loader: "css-loader"},
                    {loader: "sass-loader"}
                ]
            }
            
        ]// rules array
    }, // module
    // Absolute path to the node modules
    resolve: {
        modules: [path.join(__dirname, "node_modules")]
    }
}