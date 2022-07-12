$(document).ready(async function () {
    const getToken = async () => {
        const data2 = await fetch('/tokenuser', {
            method: 'GET',
        });
        const tokendata = await data2.json();
        console.log(tokendata.token);
         return tokendata.token;
    };

    $('#responsiveUserTable').DataTable({
        'serverSide': false,
        'ajax': {
            'url': '/api/users',
            'headers': {'Accept': "application/ld+json", "authorization": "Bearer" + " " + await getToken()},
            'dataFilter': function (data) {
                var json = JSON.parse(data);
                json.recordsTotal = json['hydra:totalItems'];
                json.recordTotal = json['hydra:totalItems'];
                json.recordsFiltered = json['hydra:totalItems'];
                json.data = json['hydra:member'];

                return JSON.stringify(json);
            }
        },
        columns: [
            { data: 'id' },
            { data: 'username' },
        ],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.12.1/i18n/de-DE.json'
        }
    });

});
