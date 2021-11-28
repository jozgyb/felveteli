class FelveteliHandler {
    constructor() {
        this.kepzes = $("#kepzesselect").val();
        this.nem = $("#nemselect").val();
        this.sorrend = $("#sorrendselect").val();
        this.json_data = {
            "operation": "",
            "kepzes": this.kepzes,
            "nem": this.nem,
            "pontszam": this.sorrend
        }
    }
    // felveteli_statisztika_nem_alapjan() {
    //     if (this.kepzes != "" && this.nem != "" && this.sorrend != "") {
    //         // hány fiú vagy lány nyert felvételt első helyen xy képzésre
    //         $.post(
    //             "felveteli",
    //             this.json_data,
    //             function (data) {
    //                 //kiirni az eredményt
    //             }
    //         );
    //     }
    // }

    fill_kepzes() {
        this.json_data.operation = "get_kepzes";
        $.post(
            "felveteli",
            this.json_data,
            function (data) {
                data.forEach(kepzes => $(kepzesDataList).append("<option value='" + kepzes.nev + "'>"));
            },
            'json'
        );
    }

    fill_nem() {

    }
    fill_sorrend() {

    }
}

$(document).ready(function () {
    let handler = new FelveteliHandler;
    handler.fill_kepzes();
    // $("#statisztikabutton").click(handler.felveteli_statisztika_nem_alapjan());
});