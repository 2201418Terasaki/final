$(function() {
$.ajaxSetup({
headers : {"X-Auth-Token" : "9efb1d1981a242df9380ca43e0985cbe"}
});
$.getJSON('https://api.football-data.org/v4/competitions/PL/standings?standingType=TOTAL', function (data_PL) {
//JSON取得後の処理
standings = data_PL.standings[0].table;
// 順位表にデータを挿入
standings.forEach(function(standing) {
$("#league-tbl").append(
'<tr align="center">'
+ '<td>' + standing.position + '</td>'
+ '<td>' + '<div style = "text-align: left"><div style="display: table-cell; vertical-align: middle;"><img src="' + standing.team.crestUrl + '" height="24"></div><div style="display: table-cell; vertical-align: middle;">'
+ standing.team.name + '</div></div></td>'
+ '<td>' + standing.playedGames + '</td>'
+ '<td>' + standing.won + '</td>'
+ '<td>' + standing.draw + '</td>'
+ '<td>' + standing.lost + '</td>'
+ '<td>' + standing.points + '</td>'
+ '</tr>'
)
});
});
});