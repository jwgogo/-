$(window).load(function () {
    $(".loading").fadeOut()
})
$(function () {
    echarts_1();
    echarts_2();
    echarts_3();
    echarts_4();
    echarts_5();
    getApi1()
    getApi4()
    zb1();
    zb2();
    zb3();


    function echarts_1() {

        api4Data = JSON.parse(localStorage.getItem("api4Data1"))

        // 基于准备好的dom，初始化echarts实例
        var myChart = echarts.init(document.getElementById('echart1'));
        option = {
            tooltip: {
                trigger: 'item',
                formatter: "{b} : {c} ({d}%)"
            },
            legend: {
                right: 0,
                top: 30,
                height: 160,
                itemWidth: 10,
                itemHeight: 10,
                itemGap: 10,
                textStyle: {
                    color: 'rgba(255,255,255,.6)',
                    fontSize: 12
                },
                orient: 'vertical',
                data: api4Data.title
            },
            calculable: true,
            series: [
                {
                    name: ' ',
                    color: ['#62c98d', '#2f89cf', '#4cb9cf', '#53b666', '#62c98d', '#205acf', '#c9c862', '#c98b62', '#c962b9', '#7562c9', '#c96262', '#c25775', '#00b7be'],
                    type: 'pie',
                    radius: [30, 70],
                    center: ['35%', '50%'],
                    roseType: 'radius',
                    label: {
                        normal: {
                            show: true
                        },
                        emphasis: {
                            show: true
                        }
                    },

                    lableLine: {
                        normal: {
                            show: true
                        },
                        emphasis: {
                            show: true
                        }
                    },

                    data: api4Data.date
                },
            ]
        };

        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
        window.addEventListener("resize", function () {
            myChart.resize();
        });
    }

    function echarts_2() {
        // 基于准备好的dom，初始化echarts实例
        var myChart = echarts.init(document.getElementById('echart2'));
        api4Data = JSON.parse(localStorage.getItem("api4Data2"))

        num = api4Data.date.length

        for (i = 0; i < num; i++) {
            api4Data.date.push({value: 0, name: "", label: {show: false}, labelLine: {show: false}})
        }


        option = {
            tooltip: {
                trigger: 'item',
                formatter: "{b} : {c} ({d}%)"
            },
            legend: {

                top: '15%',
                data: api4Data.title,
                icon: 'circle',
                textStyle: {
                    color: 'rgba(255,255,255,.6)',
                }
            },
            calculable: true,
            series: [{
                name: '',
                color: ['#62c98d', '#2f89cf', '#4cb9cf', '#53b666', '#62c98d', '#205acf', '#c9c862', '#c98b62', '#c962b9', '#c96262'],
                type: 'pie',
                //起始角度，支持范围[0, 360]
                startAngle: 0,
                //饼图的半径，数组的第一项是内半径，第二项是外半径
                radius: [51, 100],
                //支持设置成百分比，设置成百分比时第一项是相对于容器宽度，第二项是相对于容器高度
                center: ['50%', '45%'],

                //是否展示成南丁格尔图，通过半径区分数据大小。可选择两种模式：
                // 'radius' 面积展现数据的百分比，半径展现数据的大小。
                //  'area' 所有扇区面积相同，仅通过半径展现数据大小
                roseType: 'area',
                //是否启用防止标签重叠策略，默认开启，圆环图这个例子中需要强制所有标签放在中心位置，可以将该值设为 false。
                avoidLabelOverlap: false,
                label: {
                    normal: {
                        show: true,
                        //  formatter: '{c}辆'
                    },
                    emphasis: {
                        show: true
                    }
                },
                labelLine: {
                    normal: {
                        show: true,
                        length2: 1,
                    },
                    emphasis: {
                        show: true
                    }
                },
                data: api4Data.date
            }]
        };

        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
        window.addEventListener("resize", function () {
            myChart.resize();
        });
    }

    //一月
    function echarts_3() {

        $.get(
            "/admin/big/api3",
            function (res) {
                // 基于准备好的dom，初始化echarts实例
                var myChart = echarts.init(document.getElementById('echart3'));

                option = {
                    tooltip: {
                        trigger: 'axis',
                        axisPointer: {
                            lineStyle: {
                                color: '#57617B'
                            }
                        }
                    },
                    legend: {

                        //icon: 'vertical',
                        data: ['正常', '异常', '其他'],
                        //align: 'center',
                        // right: '35%',
                        top: '0',
                        textStyle: {
                            color: "#fff"
                        },
                        // itemWidth: 15,
                        // itemHeight: 15,
                        itemGap: 20,
                    },
                    grid: {
                        left: '0',
                        right: '20',
                        top: '10',
                        bottom: '20',
                        containLabel: true
                    },
                    xAxis: [{
                        type: 'category',
                        boundaryGap: false,
                        axisLabel: {
                            show: true,
                            textStyle: {
                                color: 'rgba(255,255,255,.6)'
                            }
                        },
                        axisLine: {
                            lineStyle: {
                                color: 'rgba(255,255,255,.1)'
                            }
                        },
                        data: Array.from(res.data.y).reverse(),
                    }, {}],
                    yAxis: [{
                        axisLabel: {
                            show: true,
                            textStyle: {
                                color: 'rgba(255,255,255,.6)'
                            }
                        },
                        axisLine: {
                            lineStyle: {
                                color: 'rgba(255,255,255,.1)'
                            }
                        },
                        splitLine: {
                            lineStyle: {
                                color: 'rgba(255,255,255,.1)'
                            }
                        }
                    }],
                    series: [{
                        name: '正常',
                        type: 'line',
                        smooth: true,
                        symbol: 'circle',
                        symbolSize: 5,
                        showSymbol: false,
                        lineStyle: {
                            normal: {
                                width: 2
                            }
                        },
                        areaStyle: {
                            normal: {
                                color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                                    offset: 0,
                                    color: 'rgba(24, 163, 64, 0.3)'
                                }, {
                                    offset: 0.8,
                                    color: 'rgba(24, 163, 64, 0)'
                                }], false),
                                shadowColor: 'rgba(0, 0, 0, 0.1)',
                                shadowBlur: 10
                            }
                        },
                        itemStyle: {
                            normal: {
                                color: '#cdba00',
                                borderColor: 'rgba(137,189,2,0.27)',
                                borderWidth: 12
                            }
                        },
                        data: Array.from(res.data.z).reverse()
                    }, {
                        name: '异常',
                        type: 'line',
                        smooth: true,
                        symbol: 'circle',
                        symbolSize: 5,
                        showSymbol: false,
                        lineStyle: {
                            normal: {
                                width: 2
                            }
                        },
                        areaStyle: {
                            normal: {
                                color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                                    offset: 0,
                                    color: 'rgba(39, 122,206, 0.3)'
                                }, {
                                    offset: 0.8,
                                    color: 'rgba(39, 122,206, 0)'
                                }], false),
                                shadowColor: 'rgba(0, 0, 0, 0.1)',
                                shadowBlur: 10
                            }
                        },
                        itemStyle: {
                            normal: {
                                color: '#277ace',
                                borderColor: 'rgba(0,136,212,0.2)',
                                borderWidth: 12
                            }
                        },
                        data: Array.from(res.data.c).reverse()
                    }, {
                        name: '其他',
                        type: 'line',
                        smooth: true,
                        symbol: 'circle',
                        symbolSize: 5,
                        showSymbol: false,
                        lineStyle: {
                            normal: {
                                width: 2
                            }
                        },
                        areaStyle: {
                            normal: {
                                color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                                    offset: 0,
                                    color: 'rgba(39, 122,206, 0.3)'
                                }, {
                                    offset: 0.8,
                                    color: 'rgba(39, 122,206, 0)'
                                }], false),
                                shadowColor: 'rgba(0, 0, 0, 0.1)',
                                shadowBlur: 10
                            }
                        },
                        itemStyle: {
                            normal: {
                                color: '#ce4850',
                                borderColor: 'rgba(0,136,212,0.2)',
                                borderWidth: 12
                            }
                        },
                        data: Array.from(res.data.q).reverse()
                    }]
                };

                // 使用刚指定的配置项和数据显示图表。
                myChart.setOption(option);
                window.addEventListener("resize", function () {
                    myChart.resize();
                });
            }
        )


    }

    //一周
    function echarts_4() {

        $.get(
            "/admin/big/api2",
            function (res) {
                if (res.code == 1) {


                    // 基于准备好的dom，初始化echarts实例
                    var myChart = echarts.init(document.getElementById('echart4'));
                    option = {
                        tooltip: {
                            trigger: 'axis',
                            axisPointer: {
                                lineStyle: {
                                    color: '#57617B'
                                }
                            }
                        },
                        "legend": {

                            "data": [
                                {"name": "正常"},
                                {"name": "异常"},
                                {"name": "其他"}
                            ],
                            "top": "0%",
                            "textStyle": {
                                "color": "rgba(255,255,255,0.9)"//图例文字
                            }
                        },

                        "xAxis": [
                            {
                                "type": "category",

                                data: Array.from(res.data.w).reverse(),
                                axisLine: {lineStyle: {color: "rgba(255,255,255,.1)"}},
                                axisLabel: {
                                    textStyle: {color: "rgba(255,255,255,.6)", fontSize: '14',},
                                },

                            },
                        ],
                        "yAxis": [
                            {
                                "type": "value",
                                "name": "人数",
                                "min": 0,
                                "max": 50,
                                "interval": 10,
                                "axisLabel": {
                                    "show": true,

                                },
                                axisLine: {lineStyle: {color: 'rgba(255,255,255,.4)'}},//左线色

                            },
                            {
                                "type": "value",
                                "name": "人数",
                                "show": true,
                                "axisLabel": {
                                    "show": true,

                                },
                                axisLine: {lineStyle: {color: 'rgba(255,255,255,.4)'}},//右线色
                                splitLine: {show: true, lineStyle: {color: "#001e94"}},//x轴线
                            },
                        ],
                        "grid": {
                            "top": "10%",
                            "right": "30",
                            "bottom": "30",
                            "left": "30",
                        },
                        "series": [
                            {
                                "name": "正常",

                                "type": "bar",
                                "data": Array.from(res.data.z).reverse(),
                                "barWidth": "auto",
                                "itemStyle": {
                                    "normal": {
                                        "color": {
                                            "type": "linear",
                                            "x": 0,
                                            "y": 0,
                                            "x2": 0,
                                            "y2": 1,
                                            "colorStops": [
                                                {
                                                    "offset": 0,
                                                    "color": "#609db8"
                                                },

                                                {
                                                    "offset": 1,
                                                    "color": "#609db8"
                                                }
                                            ],
                                            "globalCoord": false
                                        }
                                    }
                                }
                            },
                            {
                                "name": "异常",
                                "type": "bar",
                                "data": Array.from(res.data.c).reverse(),
                                "barWidth": "auto",

                                "itemStyle": {
                                    "normal": {
                                        "color": {
                                            "type": "linear",
                                            "x": 0,
                                            "y": 0,
                                            "x2": 0,
                                            "y2": 1,
                                            "colorStops": [
                                                {
                                                    "offset": 0,
                                                    "color": "#66b8a7"
                                                },
                                                {
                                                    "offset": 1,
                                                    "color": "#66b8a7"
                                                }
                                            ],
                                            "globalCoord": false
                                        }
                                    }
                                },
                                "barGap": "0"
                            },
                            {
                                "name": "其他",
                                "type": "line",
                                "yAxisIndex": 1,

                                "data": Array.from(res.data.q).reverse(),
                                lineStyle: {
                                    normal: {
                                        width: 2
                                    },
                                },
                                "itemStyle": {
                                    "normal": {
                                        "color": "#cdba00",

                                    }
                                },
                                "smooth": true
                            }
                        ]
                    };


                    // 使用刚指定的配置项和数据显示图表。
                    myChart.setOption(option);
                    window.addEventListener("resize", function () {
                        myChart.resize();
                    });

                }
            }
        )


    }

    function echarts_5() {

        $.get(
            "/admin/big/api7",
            function (res) {


                // 基于准备好的dom，初始化echarts实例
                var myChart = echarts.init(document.getElementById('echart5'));
// 颜色
                var lightBlue = {
                    type: 'linear',
                    x: 0,
                    y: 0,
                    x2: 0,
                    y2: 1,
                    colorStops: [{
                        offset: 0,
                        color: 'rgba(41, 121, 255, 1)'
                    }, {
                        offset: 1,
                        color: 'rgba(0, 192, 255, 1)'
                    }],
                    globalCoord: false
                }

                var option = {
                    tooltip: {
                        show: false
                    },
                    grid: {
                        top: '0%',
                        left: '20%',
                        right: '10%',
                        bottom: '0%',
                    },
                    xAxis: {
                        splitLine: {
                            show: false
                        },
                        axisTick: {
                            show: false
                        },
                        axisLine: {
                            show: false
                        },
                        axisLabel: {
                            show: false
                        }
                    },
                    yAxis: {
                        data: res.data.b,
                        axisTick: {
                            show: false
                        },
                        axisLine: {
                            show: false
                        },
                        axisLabel: {
                            color: 'rgba(255,255,255,.6)',
                            fontSize: 14
                        }
                    },
                    series: [{

                        type: 'bar',
                        label: {
                            show: true,
                            position: 'right',
                            color: '#49bcf7',
                            fontSize: 14,
                            formatter: '{c}%'

                        },
                        itemStyle: {
                            color: '#49bcf7'
                        },
                        barWidth: '15',
                        data: res.data.s,
                    }, {
                        type: 'bar',
                        barGap: '-100%',
                        itemStyle: {
                            color: '#fff',
                            opacity: 0.1
                        },
                        barWidth: '15',
                        data: res.data.n,
                    }],
                };
                // 使用刚指定的配置项和数据显示图表。
                myChart.setOption(option);
                window.addEventListener("resize", function () {
                    myChart.resize();
                });
            }
        )
    }


    //中间
    function getApi1() {


        //中间统计
        $.get(
            "/admin/big/api1",
            function (res) {

                if (res.code == 1) {

                    $('#numbtCount').html(res.data.A)
                    localStorage.setItem("api1DataB", res.data.B)
                    localStorage.setItem("api1DataC", res.data.C)
                    localStorage.setItem("api1DataD", res.data.D)
                    localStorage.setItem("api1DataE", res.data.E)
                }

            }
        )


    }

    function getApi4() {
        //中间统计
        $.get(
            "/admin/big/api4",
            function (res) {

                if (res.code == 1) {

                    $('#numbtCount').html(res.data.A)
                    localStorage.setItem("api4Data1", JSON.stringify(res.data.A))
                    localStorage.setItem("api4Data2", JSON.stringify(res.data.B))
                }

            }
        )


    }

    function zb1() {


        // 基于准备好的dom，初始化echarts实例
        var myChart = echarts.init(document.getElementById('zb1'));
        var v1 = localStorage.getItem("api1DataB")
        var v2 = localStorage.getItem("api1DataC")
        var v3 = localStorage.getItem("api1DataD")
        var v4 = localStorage.getItem("api1DataE")

        console.log(v1, v2, v3, v4)

        option = {
            series: [{

                type: 'pie',
                radius: ['60%', '70%'],
                color: '#49bcf7',
                label: {
                    normal: {
                        position: 'center'
                    }
                },
                data: [{
                    value: v1,
                    name: 'B',
                    label: {
                        normal: {
                            formatter: v1 + '',
                            textStyle: {
                                fontSize: 20,
                                color: '#fff',
                            }
                        }
                    }
                }, {
                    value: v3,
                    name: 'D',
                    label: {
                        normal: {
                            formatter: function (params) {
                                return '占比' + Math.round(v1 / v4 * 100) + '%'
                            },
                            textStyle: {
                                color: '#aaa',
                                fontSize: 12
                            }
                        }
                    },
                    itemStyle: {
                        normal: {
                            color: 'rgba(255,255,255,.2)'
                        },
                        emphasis: {
                            color: '#fff'
                        }
                    },
                }]
            }]
        };
        myChart.setOption(option);
        window.addEventListener("resize", function () {
            myChart.resize();
        });
    }

    function zb2() {
        // 基于准备好的dom，初始化echarts实例
        var myChart = echarts.init(document.getElementById('zb2'));
        var v1 = localStorage.getItem("api1DataB")
        var v2 = localStorage.getItem("api1DataC")
        var v3 = localStorage.getItem("api1DataD")
        var v4 = localStorage.getItem("api1DataE")
        option = {

//animation: false,
            series: [{
                type: 'pie',
                radius: ['60%', '70%'],
                color: '#cdba00',
                label: {
                    normal: {
                        position: 'center'
                    }
                },
                data: [{
                    value: v2,
                    name: 'C',
                    label: {
                        normal: {
                            formatter: v2 + '',
                            textStyle: {
                                fontSize: 20,
                                color: '#fff',
                            }
                        }
                    }
                }, {
                    value: v3,
                    name: '女消费',
                    label: {
                        normal: {
                            formatter: function (params) {
                                return '占比' + Math.round(v2 / v4 * 100) + '%'
                            },
                            textStyle: {
                                color: '#aaa',
                                fontSize: 12
                            }
                        }
                    },
                    itemStyle: {
                        normal: {
                            color: 'rgba(255,255,255,.2)'
                        },
                        emphasis: {
                            color: '#fff'
                        }
                    },
                }]
            }]
        };
        myChart.setOption(option);
        window.addEventListener("resize", function () {
            myChart.resize();
        });
    }

    function zb3() {
        // 基于准备好的dom，初始化echarts实例
        var myChart = echarts.init(document.getElementById('zb3'));
        var v1 = localStorage.getItem("api1DataB")
        var v2 = localStorage.getItem("api1DataC")
        var v3 = localStorage.getItem("api1DataD")
        var v4 = localStorage.getItem("api1DataE")
        option = {
            series: [{

                type: 'pie',
                radius: ['60%', '70%'],
                color: '#62c98d',
                label: {
                    normal: {
                        position: 'center'
                    }
                },
                data: [{
                    value: v3,
                    name: '女消费',
                    label: {
                        normal: {
                            formatter: v3 + '',
                            textStyle: {
                                fontSize: 20,
                                color: '#fff',
                            }
                        }
                    }
                }, {
                    value: v1,
                    name: '男消费',
                    label: {
                        normal: {
                            formatter: function (params) {
                                return '占比' + Math.round(v3 / v4 * 100) + '%'
                            },
                            textStyle: {
                                color: '#aaa',
                                fontSize: 12
                            }
                        }
                    },
                    itemStyle: {
                        normal: {
                            color: 'rgba(255,255,255,.2)'
                        },
                        emphasis: {
                            color: '#fff'
                        }
                    },
                }]
            }]
        };
        myChart.setOption(option);
        window.addEventListener("resize", function () {
            myChart.resize();
        });
    }
})



		
		
		


		









