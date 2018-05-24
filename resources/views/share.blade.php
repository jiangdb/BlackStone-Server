<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimal-ui">
	<title>{{ $work->bean_category }}</title>

	<script
	  src="https://code.jquery.com/jquery-3.3.1.min.js"
	  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
	  crossorigin="anonymous"></script>
</head>
<body>
	<div class="header">TIMEMORE Labs</div>
	<div class="detail" style="padding-left: 20px">
		<div class="header-setting">
			<div class="title">评分</div>

			<div class="value" id="rating">
				<script>
					var star = {{ $work->rating }};
					var ratingHtml;
					switch(star) {
					      case 1:
					        ratingHtml = '<div><image class="star" src="/images/star.png"></image><image class="star" src="/images/star_white.png"></image><image class="star" src="/images/star_white.png"></image><image class="star" src="/images/star_white.png"></image><image class="star" src="/images/star_white.png"></image></div><span>很差</span>'
					        break;
					      case 2:
					      	ratingHtml = '<div><image class="star" src="/images/star.png"></image><image class="star" src="/images/star.png"></image><image class="star" src="/images/star_white.png"></image><image class="star" src=" mages/star_white.png"></image><image class="star" src="/images/star_white.png"></image></div><span>差</span>'
					        break;
					      case 3:
					      	ratingHtml = '<div><image class="star" src="/images/star.png"></image><image class="star" src="/images/star.png"></image><image class="star" src="/images/star.png"></image><image class="star" src="/images/star_white.png"></image><image class="star" src="/images/star_white.png"></image></div><span>一般</span>'
					        break;
					      case 4:
					      	ratingHtml = '<div><image class="star" src="/images/star.png"></image><image class="star" src="/images/star.png"></image><image class="star" src="/images/star.png"></image><image class="star" src="/images/star.png"></image><image class="star" src="/images/star_white.png"></image></div><span>好</span>'
					        break;
					      case 5:
					      	ratingHtml = '<div><image class="star" src="/images/star.png"></image><image class="star" src="/images/star.png"></image><image class="star" src="/images/star.png"></image><image class="star" src="/images/star.png"></image><image class="star" src="/images/star.png"></image></div><span>非常棒</span>'
					        break;
					      default: null;
			      	}
			      	$(ratingHtml).appendTo('#rating')
				</script>
			</div>
		</div>
		<div class="header-setting">
			<div class="title">风味</div>
			<div class="value">{{ $work->flavor }}</div>
		</div>
		<div class="header-setting">
			<div class="title">设备</div>
			<div class="value">{{ $work->accessories }}</div>
		</div>
		<div class="feeling">
			{{ $work->feeling }}
		</div>
	</div>
	<div class="detail">
		<div class="row">
			<div class="single-setting">
				<image class="icon" src='/images/icon_brand.png'></image>
				<span class="name">咖啡豆</span>
				<span class="value">{{ $work->bean_category }}</span>
			</div>
		</div>
		<div class="row">
			<div class="single-setting">
				<image class="icon" src="/images/icon_beanweight.png"></image>
				<span class="name">粉重</span>
				<span class="value">{{ $work->bean_weight }}</span>
			</div>
			<div class="single-setting">
				<image class="icon" src="/images/icon_time.png"></image>
				<span class="name">时间</span>
				<span class="value">{{ $work->formatted_work_time }}</span>
			</div>
		</div>
		<div class="row">
			<div class="single-setting">
				<image class="icon" src="/images/icon_grandsize.png"></image>
				<span class="name">研磨度</span>
				<span class="value">{{ $work->grand_size }}</span>
			</div>
			<div class="single-setting">
				<image class="icon" src="/images/icon_temp.png"></image>
				<span class="name">水温</span>
				<span class="value">{{ $work->temperature }}℃</span>
			</div>
		</div>
		<div class="row">
			<div class="single-setting">
				<image class="icon" src="/images/icon_waterweight.png"></image>
				<span class="name">注水量</span>
				<span class="value">{{ $work->last_data[2] }}g</span>
			</div>
			<div class="single-setting">
				<image class="icon" src="/images/icon_waterweight.png"></image>
				<span class="name">萃取量</span>
				<span class="value">{{ $work->last_data[1] }}g</span>
			</div>
		</div>
		<div class="row">
			<div class="single-setting">
				<image class="icon" src="/images/icon_waterweight.png"></image>
				<span class="name">预设注水量</span>
				<span class="value">{{ $work->preset_water_weight }}g</span>
			</div>
			<div class="single-setting">
				<image class="icon" src="/images/icon_waterweight.png"></image>
				<span class="name">实际注水量</span>
				<span class="value">{{ $work->Last_Data[2] }}g</span>
			</div>
		</div>
		<div class="row">
			<div class="single-setting">
				<image class="icon" src="/images/icon_proportion.png"></image>
				<span class="name">预设粉水比</span>
				<span class="value">1:{{ $work->water_ratio }}</span>
			</div>
			<div class="single-setting">
				<image class="icon" src="/images/icon_proportion.png"></image>
				<span class="name">实际粉水比</span>
				<span class="value">1:{{ $work->real_water_ratio }}</span>
			</div>
		</div>
	</div>
	<div class="detail" id="chart"></div>

	<div style="height: 200px; width: 100%; background-color: #fff; margin-top:-20px; z-index: 10;"></div>
	
</body>
<style>
	body {
		background-color: #F3F3F3;
		width: 100%;
		display: flex;
		flex-direction: column;
		justify-content: flex-start;
		font-size: 17px;
		margin: 0;
		font-family: 'Open Sans', sans-serif;
	}
	.header {
		color: #fff;
		background-color: #000;
		height: 55px;
		width: 100%;
		display: flex;
		justify-content: center;
		align-items: center;
	}
	.detail {
		margin-top: 8px;
		background-color: #fff;
	}
	.header-setting {
		height: 55px;
		display: flex;
		justify-content: space-between;
		align-items: center;
		border-bottom: 0.5px solid #E0DEDE;
	}
	.header-setting .title {
		color: #242424;
		width: 38px;
	}
	.header-setting .value {
		color: #5b5b5b;
		text-align: right;
		margin: 10px 20px 10px 0;
	}
	.feeling {
		margin: 10px 25px 27px 26px;
		color: #5b5b5b;
	}
	.detail .row {
		display: flex;
		width: 100%;
		height: 40px;
	}
	.detail .single-setting {
		width: 50%;
		display: flex;
		align-items: center;
	}
	.single-setting .icon {
		margin-left: 15px;
		width: 20px;
		height: 22px;
	}
	.single-setting .name {
		color: #5b5b5b;
		font-size: 16px;
		margin-left: 7px;
	}
	.single-setting .value {
		margin-left: 10px;
		font-weight: bold;
		font-size: 16px;
		color: #232323;
		text-overflow: ellipsis;
		overflow: hidden;
	}
	#rating {
		display: flex;
		align-items: center;
		justify-content: space-between;
		width: calc(100% - 60px)
	}
	#rating .star {
		width: 29px;
		height: 29px;
		margin: 0 10px;
	}
</style>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
	$(function () {
		@if ($work->datas)
		@if ($work->scale_number == 2)
		var chartDatas = [
			@foreach( $work->datas as $index => $data)
			{
				index: {{ $index }},
				extract: {{ $data[1]??'null' }},
				total: {{ $data[2] }},
			},
			@endforeach
			];
		var length = chartDatas.length;
		var extract = [];
		var total = [];
		for( var i = 0; i<length; i++) {
	      let data = chartDatas[ i ]
	      extract.push({
	      	x: parseFloat(i/10),
	      	y: parseFloat(data.extract.toFixed(1))
	      })
	      total.push({
	      	x: parseFloat(i/10),
	      	y: parseFloat(data.total.toFixed(1))
	      })
	    }

	    Highcharts.chart('chart',{
	    	chart: {
	        	type: 'area',
	    		height: 320,
	    	},
	    	title: {
	    		text: 'TIMEMORE'
	    	},
	    	tooltip: {
	    		enabled: false,
	    	},
	    	plotOptions: {
	          	series: {
		            marker: {
		                enabled: false
		            }
		        },

		    },
	    	series: [
		    	{
			        name: '注水总量',
			        data: total,
			        lineWidth: 1,
			        color:'#53B2F0',
	                fillColor: {
	                    linearGradient: {
	                        x1: 0,
	                        y1: 0,
	                        x2: 0,
	                        y2: 1
	                    },
	                    stops: [
	                      	[0, 'rgb(131, 192, 232, .91)'],
	                      	[1, 'rgb(185, 225, 245, 0)']

	                    ]
	                },
			    },{
			        name: '咖啡萃取量',
			        data: extract,
			        lineWidth: 1,
			        color: '#E0B870',
	                fillColor: {
	                    linearGradient: {
	                        x1: 0,
	                        y1: 0,
	                        x2: 0,
	                        y2: 1
	                    },
	                    stops: [
	                      	[0, 'rgb(224, 184, 112, .71)'],
	                      	[1, 'rgb(231, 220, 200, 0)']
	                    ]
	                },
			    }, 
		    ],
		    xAxis: {
		        lineWidth:2,
	          	lineColor: '#ccc',
	          	tickLength: 0,
          		tickAmount: 6,
			},
			yAxis: {
			    gridLineWidth: 1,
			    title: {
			    	enabled: false
			    },
			    min: 0,
          		tickAmount: 5,
          		plotLines: [{
		            value: 0,
		            width: 1,
		            color: '#333'
	          	}],
			}
	    });
		@else
		var chartDatas = [
			@foreach( $work->datas as $index => $data)
			{
				index: {{ $index }},
				total: {{ $data[2] }},
			},
			@endforeach
			];
		var length = chartDatas.length;
		var total = [];
		for( var i = 0; i<length; i++) {
			let data = chartDatas[ i ]
			total.push({
				x: parseFloat(i/10),
				y: parseFloat(data.total.toFixed(1))
			})
		}

		Highcharts.chart('chart',{
			chart: {
				type: 'area',
				height: 320,
			},
			title: {
				text: 'TIMEMORE'
			},
			tooltip: {
				enabled: false,
			},
			plotOptions: {
				series: {
					marker: {
						enabled: false
					}
				},

			},
			series: [
				{
					name: '注水总量',
					data: total,
					lineWidth: 1,
					color:'#53B2F0',
					fillColor: {
						linearGradient: {
							x1: 0,
							y1: 0,
							x2: 0,
							y2: 1
						},
						stops: [
							[0, 'rgb(131, 192, 232, .91)'],
							[1, 'rgb(185, 225, 245, 0)']

						]
					},
				},
			],
			xAxis: {
				lineWidth:2,
				lineColor: '#ccc',
				tickLength: 0,
				tickAmount: 6,
			},
			yAxis: {
				gridLineWidth: 1,
				title: {
					enabled: false
				},
				min: 0,
				tickAmount: 5,
				plotLines: [{
					value: 0,
					width: 1,
					color: '#333'
				}],
			}
		});
		@endif
		@endif
	})
</script>
</html>