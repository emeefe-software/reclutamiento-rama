const app = new Vue({
    el: '#app',
    mounted() {
        this.recaptcha = window.grecaptcha.render('recaptcha', {
            'sitekey': google_recaptcha_key,
            'theme': 'light'
        });
    },
    data: {
        cinematografia: false,
        isVisibleHours: false,
        isVisibleNewHour: false,
        options: [{
            'text': 'Seleccionar de los existentes',
            'value': 0
        },
        {
            'text': 'Agregar nuevo',
            'value': 1
        },
        ],


        universities: dictionary.universities,
        careers: dictionary.careers,
        programs: [],
        hours: [],

        university: null,
        career: null,
        program: null,
        hour: null,
        selectedHour: null,

        withCV: false,
        withPortfolio: false,

        scheduleCompleted: false,

        summary: {
            university: null,
            career: null,
            program: null,
            hour: null
        },

        recaptcha: null,

        //Admin area
        date: null,
        time: null,
        endTime: null
    },
    watch: {
        university: function() {
            this.career = null;
            this.hour = null;
            this.hours = [];
            this.updatePrograms();
        },
        career: function(careerId) {
            this.program = null;
            this.hour = null;
            this.hours = [];
            this.updatePrograms();

            var career = this.careers.find(career => careerId == career.id);
            this.withCV = !!(career && career.withCV);
            this.withPortfolio = !!(career && career.withPortfolio);
        },
        program: function() {
            this.hour = null;
            this.hours = [];
            this.fetchAvailableHours();
        }
    },
    methods: {
        checkCareer(event) {
            var option = event.target;
            var selected = option.options[option.selectedIndex].text;
            if (selected == "Cinematografía") {
                this.cinematografia = true;
            } else {
                this.cinematografia = false;
            }
        },
        onChangeHour(event) {
            if (event.target.value == 0) {
                this.isVisibleNewHour = false;
                this.isVisibleHours = true;
            } else {
                this.isVisibleHours = false;
                this.isVisibleNewHour = true;
            }
        },

        formatTime(time) {
            return time ? time.substring(0, 5) : null;
        },

        updatePrograms: function() {
            var _this = this;
            if (!this.university || !this.career) return;

            this.programs = (
                this.universities.find(function(uni) {
                    return uni.id == _this.university;
                }).programs || []
            ).filter(function(program) {
                return (
                    program.careers.includes("" + _this.career) ||
                    program.careers.includes(Number(_this.career))
                ); //Validar ambos casos string o int
            });

            this.fetchAvailableHours();
        },

        fetchAvailableHours: function() {
            if (!this.career || !this.program || !this.university) return;

            var _this = this;
            fetch(
                "/api/available-hours?career=" +
                    _this.career +
                    "&program=" +
                    _this.program,
                {
                    method: "GET",
                    headers: {
                        "Content-Type": "application/json"
                    }
                }
            )
                .then(res => res.json())
                .catch(error => console.error("Error:", error))
                .then(response => (this.hours = response));
        },

        submit: function() {
            //Validacion de correo
            var emailInput = document.querySelector("#email");
            var gmail = document.querySelector("#skype");
            var gmailRegex = /^[^\s@]+@gmail\.com$/;

            if (emailInput) {
                var email = emailInput.value.trim();
                var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                if (!emailRegex.test(email)) {
                    Swal.fire({
                        icon: "warning",
                        title: "Correo inválido",
                        text: "Por favor ingresa un correo electrónico válido."
                    });
                    return;
                }
            }

            if (!gmailRegex.test(gmail.value.trim())) {
                Swal.fire({
                    icon: "warning",
                    title: "Correo Gmail inválido",
                    text:
                        "Proporciona un correo Gmail para contactarte por meet"
                });
                return;
            }

            //Validacion de telefono
            var phoneInput = document.querySelector('#phone');
            if (phoneInput) {
                var phone = phoneInput.value.trim();
                var phoneRegex = /^\d{10}$/;

                if (!phoneRegex.test(phone)) {
                    Swal.fire({
                        icon: "warning",
                        title: "Teléfono inválido",
                        text:
                            "El número debe tener exactamente 10 dígitos (ej. 5523456789)."
                    });
                    return;
                }
            }

            var _this = this;
            Vue.Loader.show("Enviando", "Enviando solicitud de entrevista");
            var formData = new FormData();

            var inputNodes = document.querySelectorAll("[name]");
            for (var i = 0; i < inputNodes.length; i++) {
                var element = inputNodes[i];
                if (element.type == "file") {
                    if (element.files.length)
                        formData.append(element.name, element.files[0]);
                } else {
                    formData.append(element.name, element.value);
                }
            }

            axios
                .post(this.$refs.form.action, formData)
                .then(function(response) {
                    _this.summary = {
                        university:
                            _this.$refs.university.options[
                                _this.$refs.university.selectedIndex
                            ].innerHTML,
                        career:
                            _this.$refs.career.options[
                                _this.$refs.career.selectedIndex
                            ].innerHTML,
                        program:
                            _this.$refs.program.options[
                                _this.$refs.program.selectedIndex
                            ].innerHTML,
                        hour: _this.$refs.hour
                            ? _this.$refs.hour.options[
                                  _this.$refs.hour.selectedIndex
                              ].innerHTML
                            : _this.$refs.time
                            ? _this.$refs.time.value
                            : ""
                    };

                    _this.scheduleCompleted = true;
                    Vue.Loader.hide();
                    setTimeout(() => {
                        location.href = "#completed";
                    }, 500);
                })
                .catch(function(error) {
                    Vue.Loader.hide();

                    if (error.response && error.response.status == 422) {
                        let validationErrors = error.response.data.errors;
                        let htmlResponse = "";
                        for (
                            let index = 0;
                            index < Object.values(validationErrors).length;
                            index++
                        ) {
                            let errors = Object.values(validationErrors)[index];
                            for (let j = 0; j < errors.length; j++) {
                                htmlResponse += "<li>" + errors[j] + "</li>";
                            }
                        }

                        let html = document.createElement("ul");
                        html.innerHTML = htmlResponse;

                        Swal.fire({
                            title: "Ocurrieron los siguientes errores",
                            html: html,
                            icon: "error"
                        });

                        return;
                    }

                    if (
                        error.response &&
                        error.response.data &&
                        error.response.data.msg
                    ) {
                        Swal.fire({
                            text: error.response.data.msg,
                            icon: "error"
                        });
                        return;
                    }

                    Swal.fire({
                        text: "Ocurrió un error",
                        icon: "error"
                    });
                });
        }
    }
});

if (document.getElementById("hourResponsable")) {
    const hour = new Vue({
        el: "#hourResponsable",
        mounted() {},
        data() {
            var startDate = new Date();
            startDate.setDate(startDate.getDate() + 1);

            return {
                date: null,
                time: null,
                endTime: null,
                context: null,
                contextEnd: null,
                timeFormatted: null,
                endTimeFormatted: null,
                startDate: startDate
            };
        },
        watch: {
            time: function(newTime) {
                this.timeFormatted = newTime ? newTime.substring(0, 5) : null;
            },
            endTime: function(newTime) {
                this.endTimeFormatted = newTime
                    ? newTime.substring(0, 5)
                    : null;
            }
        },
        methods: {
            onContext(ctx) {
                this.context = ctx;
            },
            onContextEnd(ctx) {
                this.contextEnd = ctx;
            },
            formatTime(time) {
                return time ? time.substring(0, 5) : null;
            }
        }
    });
}
