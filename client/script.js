
var app = new Vue({
    el: '#app',
    data: {
        errorMsg: "",
        successMsg: "",
        showAddForm: false,
        showEditForm: false,
        showDeleteForm: false,
        games: [],
        newGame: {
            date: "",
            week: "",
            opp: "",
            result: "",
            score: "",
            comp: "",
            compPerc: "",
            yds: "",
            td: "",
            int: "",
            rate: "",
            rushyds: ""
        },
        currentGame: {}
    },
    mounted: function() {
        this.getAllGames();
    },
    methods: {
        getAllGames() {
            axios.get("http://localhost/Patrick_Mahomes_Stats/server/routes.php?action=read").then(function(response) {
                if (response.data.error) {
                    app.errorMsg = response.data.message;
                } else {
                    app.games = response.data;
                }
            })
        },
        addGame() {
            var formData = app.toFormData(app.newGame);

            axios.post("http://localhost/Patrick_Mahomes_Stats/server/routes.php?action=create", formData).then(function(response) {
                app.newGame = {
                    date: "",
                    week: "",
                    opp: "",
                    result: "",
                    score: "",
                    comp: "",
                    compPerc: "",
                    yds: "",
                    td: "",
                    int: "",
                    rate: "",
                    rushyds: ""
                };

                if (response.data.error) {
                    app.errorMsg = response.data;
                } else {
                    console.log(response.data)
                    app.successMsg = response.data;
                    app.getAllGames();
                }
            })
        },
        updateGame() {
            var formData = app.toFormData(app.currentGame);

            axios.post("http://localhost/Patrick_Mahomes_Stats/server/routes.php?action=update", formData).then(function(response) {
                app.currentGame = {};

                if (response.data.error) {
                    app.errorMsg = response.data;
                } else {
                    console.log(response.data)
                    app.successMsg = response.data;
                    app.getAllGames();
                }
            })           
        },
        selectGame(game) {
            app.currentGame = game;
        },
        toFormData(obj) {
            var convertData = new FormData();

            for (var i in obj) {
                convertData.append(i, obj[i]);
            }

            return convertData;
        },
        deleteGame() {
            var formData = app.toFormData(app.currentGame);

            axios.post("http://localhost/Patrick_Mahomes_Stats/server/routes.php?action=delete", formData).then(function(response) {
                app.currentGame = {};
                if (response.data.error) {
                    app.errorMsg = response.data.message;
                } else {
                    console.log(response.data)
                    app.successMsg = response.data;
                    app.getAllGames();
                }
            })
        },
        clearMsg() {
            app.errorMsg = "";
            app.successMsg = "";
        }
    }
})