// Toggle dropdown
$(document).ready(() => {
    $('dropdown-toggle').dropdown()
    $('#show').text($(".dropdown1 button[id='default-option']").text());
});


const app = new Vue({
    el: '#app',
    data: {
        errorMsg: "",
        successMsg: "",
        showAddForm: false,
        showEditForm: false,
        showDeleteForm: false,
        totals: [],
        averages: [],
        results: [],
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


    mounted() {
        this.getTotals("twentytwenty")
        this.getAverages("twentytwenty")
        this.getAllGames("twentytwenty")
        this.getResults("twentytwenty")
        this.currentGame.season = "twentytwenty"
    },

    methods: {
        selectSeason(season) {
            app.currentGame.season = season
        },

        selectGame(game) {
            app.currentGame = game
        },

        toFormData: function (obj) {
            const convertData = new FormData()
            for (let i in obj) if (obj.hasOwnProperty(i)) convertData.append(i, obj[i])

            return convertData
        },

        clearMsg() {
            app.errorMsg = ""
            app.successMsg = ""
        },

        getAllGames(season) {
            axios.get(`http://localhost/Patrick_Mahomes_Stats/server/routes.php?action=read/${season}`)
                 .then((response) => {
                    if (response.data.error) {
                        app.errorMsg = response.data.message
                    } else {
                        app.games = response.data
                    }
                }
            )
        },

        addGame(season) {
            const formData = app.toFormData(app.newGame)

            axios.post(`http://localhost/Patrick_Mahomes_Stats/server/routes.php?action=create/${season}`, formData)
                 .then((response) => {
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
                        app.errorMsg = response.data
                    } else {
                        app.successMsg = response.data
                    }

                    app.getAllGames(season)
                }
            )
        },

        updateGame(season) {
            const formData = app.toFormData(app.currentGame)

            axios.post(`http://localhost/Patrick_Mahomes_Stats/server/routes.php?action=update/${season}`, formData)
                 .then((response) => {

                    app.currentGame = {}

                    if (response.data.error) {
                        app.errorMsg = response.data
                    } else {
                        app.successMsg = response.data
                    }

                     app.getAllGames(season)
                }
            )
        },

        deleteGame(season) {
            const formData = app.toFormData(app.currentGame)

            axios.post(`http://localhost/Patrick_Mahomes_Stats/server/routes.php?action=delete/${season}`, formData)
                 .then((response) => {
                    app.currentGame = {}

                    if (response.data.error) {
                        app.errorMsg = response.data.message
                    } else {
                        app.successMsg = response.data
                    }

                     app.getAllGames(season)
                }
            )
        },

        getTotals(season) {
            axios.get(`http://localhost/Patrick_Mahomes_Stats/server/routes.php?action=totals/${season}`)
                .then((response) => {
                        if (response.data.error) {
                            app.errorMsg = response.data.message
                        } else {
                            app.totals = response.data
                        }
                    }
                )
        },

        getAverages(season) {
            axios.get(`http://localhost/Patrick_Mahomes_Stats/server/routes.php?action=averages/${season}`)
                .then((response) => {
                        if (response.data.error) {
                            app.errorMsg = response.data.message
                        } else {
                            app.averages = response.data
                        }
                    }
                )
        },

        getResults(season) {
            axios.get(`http://localhost/Patrick_Mahomes_Stats/server/routes.php?action=results/${season}`)
                .then((response) => {
                        if (response.data.error) {
                            app.errorMsg = response.data.message
                        } else {
                            app.results = response.data
                        }
                    }
                )
        }

    }

})