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
        this.json_data.operation = "get_nem";
        $.post(
            "felveteli",
            this.json_data,
            function (data) {
                data.forEach(nem => $(nemDataList).append("<option value='" + nem.nem + "'>"));
            },
            'json'
        ).fail(function(xhr, status, error) {
            // console.log(xhr);
            // alert(error);
        });
    }

    fill_sorrend() {
        this.json_data.operation = "get_sorrend";
        $.post(
            "felveteli",
            this.json_data,
            function (data) {
                console.log(data);
                data.forEach(sorrend => $(sorrendDataList).append("<option value='" + sorrend.sorrend + "'>"));
            },
            'json'
        ).fail(function(xhr, status, error) {
            console.log(xhr);
            // alert(error);
        });
    }
}

$(document).ready(function () {
    var handler = new FelveteliHandler;
    handler.fill_kepzes();
    handler.fill_nem();
    handler.fill_sorrend();
    // $("#statisztikabutton").click(handler.felveteli_statisztika_nem_alapjan());
});