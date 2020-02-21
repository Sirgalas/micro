
Skip to content
Pull requests
Issues
Marketplace
Explore
@Sirgalas
ElisDN /
rabbit-demo-spa

5
16

22

Code
Issues 0
Pull requests 0
Actions
Projects 0
Wiki
Security
Insights
rabbit-demo-spa/frontend/src/views/Login.vue
@ElisDN ElisDN Added frontend login cd37e95 on 17 Oct 2018
58 lines (56 sloc) 1.55 KB
<template>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Login
                </div>
                <div class="card-body">
                    <b-alert variant="danger" v-if="error" show>{{ error }}</b-alert>
                    
                    <b-form @submit="login">
                        <b-form-group label="Email address" label-for="loginEmail">
                            <b-form-input id="loginEmail" type="email" v-model="form.email" required></b-form-input>
                        </b-form-group>
                        <b-form-group label="Password" label-for="loginPassword">
                            <b-form-input id="loginPassword" type="password" v-model="form.password" required></b-form-input>
                        </b-form-group>
                        <b-button type="submit" variant="primary">Login</b-button>
                    </b-form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                form: {
                    email: this.$store.state.currentEmail,
                    password: null,
                },
                error: null
            }
        },
        methods: {
            login(event) {
                event.preventDefault();
                this.error = null;
                this.$store.dispatch('login', {
                    username: this.form.email,
                    password: this.form.password,
                })
                    .then(() => {
                        this.$router.push({name: 'home'});
                    })
                    .catch(error => {
                        if (error.response) {
                            this.error = error.response.data.error;
                        } else {
                            console.log(error.message);
                        }
                    });
            }
        }
    }
</script>

