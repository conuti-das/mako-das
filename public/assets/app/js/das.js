$(document).ready(async function () {
    const getToken = async () => {
        const data2 = await fetch('/tokenuser', {
            method: 'GET',
        });
        const tokendata = await data2.json();
         return tokendata.token;
    };

    $('#responsiveDasTable').DataTable({
        'serverSide': false,
        'ajax': {
            'url': '/api/market_messages',
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
            { data: 'status' },
            { data: 'sender' },
            { data: 'receiver' },
            { data: 'reference' },
            { data: 'type' },
            { data: 'businessTransaction' },
            { data: 'direction' },
            { data: 'description' },
            { data: 'businessKey' },
            { data: 'id' , render : function ( data, type, row, meta ) {
                    return type === 'display'  ?
                        '                                    <button type="button" data-value="'+ data +'" class="btn' +
                        ' btn-outline-primary waves-effect"\n' +
                        '                                            data-bs-toggle="modal" data-bs-target="#xlarge" id="onshowbtn">\n' +
                        '                                       Info' +
                        '                                    </button>' :
                        data;
            }},
        ],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.12.1/i18n/de-DE.json'
        }
    });

});
