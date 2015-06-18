var margin = { top: 10, right: 25, bottom: 45, left: 20 },
	width = parseInt(d3.select('#itemScatter').style('width')),
    width = width - margin.left - margin.right,
    height = 440 - margin.top - margin.bottom;
    halfImage = 8;

// d3.json("data/BRONZE.json", function(error, data) {
// d3.json("data/SILVER.json", function(error, data) {
// d3.json("data/GOLD.json", function(error, data) {
// d3.json("data/PLATINUM.json", function(error, data) {
// d3.json("data/DIAMOND.json", function(error, data) {
// d3.json("data/CHALLENGER.json", function(error, data) {

function update( rank ) {

  d3.select('svg').remove();

  d3.json("data/"+rank+".json", function(error, data) {

var xScale = d3.scale.linear()
        	   .domain([-.01, d3.max(data, function(d) { return d["winPercent"]; })])
          	   .range([ 14 + halfImage, width ]),
    xAxis = d3.svg.axis().scale(xScale).orient("bottom");

var yScale = d3.scale.log()
			   .base(10)
	    	   .domain([d3.min(data, function(d) { return d["buyPercent"]; }),
                  // -((d3.max(data, function(d) { return d["buyPercent"]; })-
                  //   d3.min(data, function(d) { return d["buyPercent"]; }))/8000),
                    d3.max(data, function(d) { return d["buyPercent"]; })])
	    	   .range([ height, 0 ]);
var yAxis = d3.svg.axis().scale(yScale).orient("left");

var tip = d3.tip()
  .attr('class', 'd3-tip')
  .offset([-10, 0])
  .html(function(d) {
  	if (d["id"] == 0) {
		return "<div width='100%'><img width='32px' id='tipImg' src='https://static.tsviewer.com/images/games/lol.gif' alt="+d["id"]+" /></div><span margin-top='4px' align='center' style='color:white'>" + d['name'] + "</span>";
	};
    return "<div width='100%'><img id='tipImg' src='https://ddragon.leagueoflegends.com/cdn/5.11.1/img/item/"+d["id"]+".png' alt="+d["id"]+" /></div><span align='center' style='color:white'>" + d['name'] + "</span>";
  })

var svg = d3.select('#itemScatter').append('svg')
    .attr('width', width + margin.left + margin.right)
    .attr('height', height + margin.top + margin.bottom)
  .append('g')
    .attr('transform', 'translate(' + margin.left + ',' + margin.top + ')');

svg.call(tip);

svg.selectAll("scatter-dots")
	.data(data)
	.enter()
.append("clipPath")
	.attr('id', function(d) { return "clipCircle-"+d["id"];})
.append('circle')
	.attr('r',8)
	.attr('cx',function (d) { return xScale(d["winPercent"]);})
	.attr('cy',function (d) { return yScale(d["buyPercent"]);});

svg.selectAll("scatter-dots")
	.data(data)
	.enter()
.append("image")
	.attr('class', 'champion-circle')
    .attr("xlink:href", function (d) { 
    	if (d["id"] == 0) {
    		return "https://static.tsviewer.com/images/games/lol.gif";
    	};
    	return "https://ddragon.leagueoflegends.com/cdn/5.11.1/img/item/"+d["id"]+".png";
    	// return "media/"+d["id"]+".png";
    })
    .attr("x", function (d) { return xScale(d["winPercent"]) - halfImage;})
    .attr("y", function (d) { return yScale(d["buyPercent"]) - halfImage;})
    .attr("width", 16)
    .attr("height", 16)
    .attr("clip-path", function(d) { return "url(#clipCircle-"+d["id"]+")"})
    .on('mouseover', tip.show)
    .on('mouseout', tip.hide);

// x-axis
svg.append("g")
  .attr("class", "x axis")
  .attr("transform", "translate(0," + (height + 8) + ")")
  .call(xAxis)
.append("text")
  .attr("class", "label")
  .attr("x", width / 2 )
  .attr("y", 35)
  .style("text-anchor", "middle")
  .text("Win %");

// y-axis
svg.append("g")
  .attr("class", "y axis")
  .attr("transform", "translate(" + margin.left + ",0)")
  .call(yAxis)
.append("text")
  .attr("class", "label")
  .attr("transform", "rotate(-90)")
  .attr("y", 6)
  .attr("dy", ".71em")
  .style("text-anchor", "end")
  .text("Purchase %");

});}

update('UNRANKED');

$('.btnPlay').click(function(e){
    $('#overlay').fadeIn(500);
});

$('#overlay').click(function(e){
    $('#overlay').fadeOut(500);
});

$('#searchBox').keydown(function(e){
    if (event.keyCode == 13){
    $('#warning').fadeIn(500);
  }
});

$('#warning').click(function(e){
    $(this).fadeOut(500);
});



