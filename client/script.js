
const app = new Vue({

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
    
    mounted() {
        this.getAllGames()
    },

    methods: {

        selectGame(game) {
            app.currentGame = game
        },

        toFormData(obj) {

            const convertData = new FormData()

            for (let i in obj) {
                convertData.append(i, obj[i])
            }

            return convertData

        },

        clearMsg() {
            app.errorMsg = ""
            app.successMsg = ""
        },

        getAllGames() {

            axios.get("http://localhost/Patrick_Mahomes_Stats/server/routes.php?action=read")
                 .then((response) => {

                    if (response.data.error) {
                        app.errorMsg = response.data.message
                    } else {
                        app.games = response.data
                    }

                }
            )

        },

        addGame() {

            const formData = app.toFormData(app.newGame)

            axios.post("http://localhost/Patrick_Mahomes_Stats/server/routes.php?action=create", formData)
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
                        app.getAllGames()
                    }

                }
            )

        },

        updateGame() {

            const formData = app.toFormData(app.currentGame)

            axios.post("http://localhost/Patrick_Mahomes_Stats/server/routes.php?action=update", formData)
                 .then((response) => {

                    app.currentGame = {}

                    if (response.data.error) {
                        app.errorMsg = response.data
                    } else {
                        app.successMsg = response.data
                        app.getAllGames()
                    }
                }
            ) 

        },

        deleteGame() {

            const formData = app.toFormData(app.currentGame)

            axios.post("http://localhost/Patrick_Mahomes_Stats/server/routes.php?action=delete", formData)
                 .then((response) => {

                    app.currentGame = {}

                    if (response.data.error) {
                        app.errorMsg = response.data.message
                    } else {
                        app.successMsg = response.data
                        app.getAllGames()
                    }
                }
            )

        }

    }

})