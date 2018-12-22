const path 					= require('path');
const weback				= require('webpack');
const MiniCssExtractPlugin	= require('mini-css-extract-plugin');

module.exports = {
	entry: './src/scss/style.scss',
	output: {
		path: path.resolve(__dirname, './public/css'),
	},
	module: {
		rules: [
			{
		        test: /\.[s?]css$/,
		        use: [
		        	MiniCssExtractPlugin.loader,
	          		{ loader: 'css-loader', options: { importLoaders: 1 } },
	          		'sass-loader',
		        ]
		    }
		]
	},
	plugins: [
		new MiniCssExtractPlugin({
			filename: "app.css"
		})
	]
}
