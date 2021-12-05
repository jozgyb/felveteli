class GraphHandler {
    constructor() {
        this.json_data = {
            "operation": ""
        }
    }

    handle_graph(kepzesek, felvettek_szama) {
        const data = {
            labels: kepzesek,
            datasets: [{
                label: kepzesek,
                backgroundColor: 'rgb(21, 143, 173)',
                borderColor: 'rgb(21, 143, 173)',
                data: felvettek_szama,
            }]
        };

        const config = {
            type: 'bar',
            data: data,
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Középiskolai jelentkezések száma válaszott szakok alapján'
                    },
                    legend: {
                        display: false
                    }
                }
            }
        };

        const myChart = new Chart(
            document.getElementById('felveteliChart'),
            config
        );
    }

    get_graph_data() {
        this.json_data.operation = "get_graph_data_ajax";
        var self = this;
        $.post(
            "felveteli",
            this.json_data,
            function (data) {
                var kepzesek = [];
                var felvettek_szama = [];
                data.forEach(function (statisztika) {
                    kepzesek.push(statisztika.kepzes);
                    felvettek_szama.push(statisztika.felvettek_szama);
                });
                self.handle_graph(kepzesek, felvettek_szama);
            },
            'json'
        ).fail(function (xhr, status, error) {
            console.log(xhr);
            alert(error);
        });
    }
}

$(document).ready(function () {
    let graph = new GraphHandler;
    graph.get_graph_data();
});