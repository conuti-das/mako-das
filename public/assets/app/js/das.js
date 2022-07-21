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
            { data: 'createdAt', render: $.fn.dataTable.render.moment(null, 'DD.MM.YY HH:mm:ss', 'de') },
            { data: 'sender' },
            { data: 'receiver' },
            { data: 'reference' },
            { data: 'type' },
            { data: 'businessTransaction' },
            { data: 'description' },
            { data: 'businessKey' },
            { data: 'id' , render : function ( data, type, row, meta ) {
                    return type === 'display'  ?
                        '                                    <button type="button" data-value="'+ data +'" data-id="'+ row["businessKey"] +'" class="btn' +
                        ' btn-outline-primary waves-effect"\n' +
                        '                                            data-bs-toggle="modal" data-bs-target="#xlarge" id="onshowbtn">\n' +
                        '                                       PROZESS' +
                        '                                    </button>' :
                        data;
            }},
        ],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.12.1/i18n/de-DE.json'
        },
        order: [[0, 'desc']],
    });


    var diagramUrl = 'https://cdn.staticaly.com/gh/bpmn-io/bpmn-js-examples/dfceecba/starter/diagram.bpmn';

    // viewer instance


    async function fetchDiagram(url) {
        const diagram = await fetch(url, {
            method: 'GET',
        });
        const jsondiagram = await diagram.json();
        return jsondiagram.bpmn20Xml;
    }

    async function fetchActivity(url) {
        const activity = await fetch(url, {
            method: 'GET',
        });
        const jsonactivity = await activity.json();
        return jsonactivity;
    }

    /**
     * Open diagram in our viewer instance.
     *
     * @param {String} bpmnXML diagram to display
     */
    async function openDiagram(processKey, processId, i) {
        url = 'http://mako-dev.apps.conuti.de:8082/camunda/process-definition/key/'+processKey+'/xml';
        // import diagram
        try {
            var bpmnViewer = new BpmnJS({
                container: '#canvas' + i
            });


            await fetchDiagram(url).then(async processesXml => {
                bpmnViewer.importXML(processesXml);

                // access viewer components
                var canvas = bpmnViewer.get('canvas');

                canvas.zoom('fit-viewport');

                aurl = 'http://mako-dev.apps.conuti.de:8082/camunda/history/activity-instance?processInstanceId=' + processId;
                await fetchActivity(aurl).then(acivities => {
                  //  var overlays = bpmnViewer.get('overlays');



                    $.each( acivities, function( key, activity ) {

                        canvas.addMarker(activity.activityId, 'needs-discussion');
                        canvas.addMarker(activity.activityId, 'highlight');

                        /**
                         overlays.add(activity.activityId, 'note', {
                            position: {
                                bottom: 0,
                                right: 0
                            },
                            html: '<div class="diagram-note">'+activity.durationInMillis+'</div>'
                        });

                         */


                    });

                });

            });

        } catch (err) {
            console.error('could not import BPMN 2.0 diagram', err);
        }
    }


    async function fetchProcess(businessKey) {
        const response = await fetch('http://mako-dev.apps.conuti.de:8082/camunda/history/process-instance?processInstanceBusinessKey=' + businessKey);
        const processes = await response.json();
        return processes;
    }


    var showModalTrigger = document.getElementById('xlarge');

    showModalTrigger.addEventListener('show.bs.modal', function () {

        console.log(showModalTrigger);
        console.log($(this));
        var button = $(event.relatedTarget) //Button that triggered the modal
        var businessKey = button.data('id');

        i = 0;

        fetchProcess(businessKey).then(processeses => {
            processeses = processeses.reverse();
            $.each( processeses, function( key, processes ) {
                i++;
console.log(processes);
                statusclass = processes.state === 'COMPLETED' ? 'bg-primary' : 'bg-info';
                var end = moment(processes.endTime);
                var start = moment(processes.startTime);
                start.locale('de');
                $('#prozesse').append('  <li class="timeline-item">\n' +
                    '                  <span class="timeline-point timeline-point-indicator"></span>\n' +
                    '                             <div class="timeline-event">\n' +
                    '                                                    <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">\n' +
                    '                                                       <h6>'+processes.processDefinitionName+'</h6>\n' +
                    '                                                        <span class="timeline-event-time">'+start.fromNow()+'</span>\n' +
                    '                                  </div>\n' +
                    '                                                  <p>'+start.format('DD.MM.YY HH:ss')+' -> '+end.format('DD.MM.YY HH:ss')+' </p>\n' +
                    '                               <p><span><b>ProcessKey : </b>'+processes.processDefinitionKey+'</span> <span><b>ProcessId : </b>'+processes.id+'</span> <span><a href="http://mako-dev.apps.conuti.de:8050/camunda/app/cockpit/default/#/history/process-instance/' + processes.id + '" target="_blank">Prozess in Camunda öffnen</a></span></p>' +
                    '                                              <div class="d-flex flex-row align-items-center">\n' +
                    '                                          <span class="badge badge-glow '+statusclass+'">'+processes.state+'</span>\n' +
                    '                            </div>\n' +
                    '                                   </div>\n' +
                    '                      </li>');



                $('#diagramhead').append('                <li class="nav-item">\n' +
                    '                    <a class="nav-link" id="tab'+i+'" data-bs-toggle="tab" href="#tab'+i+'-fill" role="tab"\n' +
                    '                       aria-controls="tab'+i+'-fill" aria-selected="true">'+processes.processDefinitionName+'</a>\n' +
                    '                </li>');

                $('#diagramholder').append('                <div class="tab-pane" id="tab'+i+'-fill" role="tabpanel" aria-labelledby="tab'+i+'-fill">\n' +
                    '                    <p><div id="info'+i+'" style="height: 75px"></div>\n' +
                    '                                    <div id="canvas'+i+'" class="camundacanvas" ' +
                    '                                    </div>\n' +
                    '                    </p>\n' +
                    '                    <p>\n' +

                    '                    </p>\n' +
                    '                </div>');



                openDiagram(processes.processDefinitionKey, processes.id, i);
            });

        });


    });


});

$(document).ready(function() {
    $('#reload').click(function() {
        console.log('reload');
        var table = $('#responsiveDasTable').DataTable();
        table.ajax.reload();
    });

    $('#sendedi').click(function() {
        let htmlMessage = $('#edi').val().replace(/(\r\n|\n|\r)/gm, "");

        $.ajax({
            type: 'POST',
            url: 'http://mako-dev.apps.conuti.de:8082/test/startProcess',
            data: '{\n' +
                '  "variables": {\n' +
                '    "payload": {\n' +
                '      "value": "'+ htmlMessage +'",\n' +
                '      "type": "String"\n' +
                '    }\n' +
                '   }\n' +
                '  }', // or JSON.stringify ({name: 'jonas'}),
            success: function(data) {
                var myModalEl = document.getElementById('sendMessageModal')
                var modal = bootstrap.Modal.getInstance(myModalEl)
                modal.toggle();



                $('#toastid').html(data.businessKey);
                $('#toastbody').html('Prozess mit Business Key ' + data.businessKey + ' erfolgreich gestartet </br>' + '<a href="http://mako-dev.apps.conuti.de:8050/camunda/app/cockpit/default/#/history/process-instance/' + data.id + '" target="_blank">Prozess in Camunda öffnen</a> ');

                var toastLiveExample = document.getElementById('liveToast')
                var toast = new bootstrap.Toast(toastLiveExample)

                toast.show()

                },
            contentType: "application/json",
            dataType: 'json'
        });
    });

});