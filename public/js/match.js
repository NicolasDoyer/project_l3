$(document).ready(function(){

    // Create pari AJAX
    $('button.pari').on('click', function(){
        let row = $(this).closest('tr');

        let matchInfo = row.find('button.pari').data('match_id').split('_');
        let team1 = matchInfo[0];
        let team2 = matchInfo[1];
        let score_team1 = row.find('td.pari input[name="team1"]').val();
        let score_team2 = row.find('td.pari input[name="team2"]').val();
        let date = matchInfo[2];

        let data = {team1,team2,score_team1,score_team2,date};

        $.post("/pari/create", data, function(response){
            let alertClass = response.success ? 'alert alert-success alert-dismissible' : 'alert alert-danger alert-dismissible';
            row.find('button.pari').text('Modifier votre pari');
            let message
            switch (response.type) {
                case 'created':
                    message = 'Votre pari a bien été créer';
                    break;
                case 'updated':
                    message = 'Votre pari a bien été modifier';
                    break;
                case 'closed':
                    message = 'Les paris sur ce match sont fermés';
                    break;
                default:
                    message = 'Erreur interne';
            }


            $('body .container:eq(1)').prepend(
                `<div class="${alertClass}">
                    <a class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    ${message}
                </div>`
            );
        })
    });


    // Refresh live matches
    let ids = [];
    $('.liveon').find('button.pari').each(function(){
        ids.push($(this).data('match_id'));
    })

    for(const id of ids) {
        refreshMatch(id);
    }
});

function refreshMatch(id){
    $.post("/matches/getfromid", {id}, function(match){
        if(!match) return;

        $(`#${id} td.score`).text(match.score ? `${match.score[0]} - ${match.score[1]}` : 'Prochainement ...');

        if(match.live) {
            setTimeout(function(){
                refreshMatch(id);
            },2000);
        } else {
            $(`#${id} td.date`).html('Terminé');
        }
    });
}