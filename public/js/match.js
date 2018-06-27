$(document).ready(function(){

    // Create pari AJAX
    $('button.pari').on('click', function(){
        let row = $(this).closest('tr');

        let matchInfo = row.find('button.pari').data('match_id').split('_');
        let team1 = matchInfo[0];
        let team2 = matchInfo[1];
        let score_team1 = row.find('td.score input[name="team1"]').val();
        let score_team2 = row.find('td.score input[name="team2"]').val();
        let date = matchInfo[2];


        let data = {team1,team2,score_team1,score_team2,date};

        $.post("/pari/create", data, function(response){
            data = JSON.parse(response);
            row.find('button.pari').text('Modifier votre pari');
            if(Object.getOwnPropertyNames(data)[0] === "success"){
                $('body .container:eq(1)').prepend(
                    "<div class=\"alert alert-success alert-dismissible\">\n" +
                    "                <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>\n" +
                    data.success+
                    "            </div>"
                );
            }
            else if(Object.getOwnPropertyNames(data)[0] === "error"){
                $('body .container:eq(1)').prepend(
                    "<div class=\"alert alert-danger alert-dismissible\">\n" +
                    "                <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>\n" +
                    data.error+
                    "            </div>"
                );
            }
        })
    });


    // Refresh live matches
    let ids = [];
    $('.liveon').find('button.pari').each(function(){
        ids.push($(this).data('match_id'));
    })
    refreshMatch();
});

function refreshMatch(ids){
    $.post("/matches/getfromid", ids, function(response){
        console.log("refresh");
    });
    setTimeout(function(){
        refreshMatch(ids);
    },2000);
}