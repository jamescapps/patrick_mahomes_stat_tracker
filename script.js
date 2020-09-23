
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
            compPercent: "",
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
            axios.get("http://localhost/Patrick_Mahomes_Stats/process.php?action=read").then(function(response) {
                if (response.data.error) {
                    app.errorMsg = response.data.message;
                } else {
                    app.games = response.data;
                }
            })
        },
        selectGame(game) {
            app.currentGame = game;
        }
    }
})