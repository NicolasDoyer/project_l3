$('button.pari').on('click', function(){
    let row = $(this).closest('tr');
    let team1 = row.find('td.team1').text();
    let team2 = row.find('td.team2').text();
    let score_team1 = row.find('td.score input[name="team1"]').val();
    let score_team2 = row.find('td.score input[name="team2"]').val();
    let date = row.find('td.date').text();

    let data = {team1,team2,score_team1,score_team2,date};

    $.post("/pari/create", data, function(response){
        console.log(response);
    })
});