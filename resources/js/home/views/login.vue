<template>
    <div class="flexBox">
        <div class="blackBox">
            <h1 class="h1Header">login</h1>
            <div v-if="errorMessage" class="invalid-feedback">
                {{ errorMessage }}
            </div>
            <Form @submit="login" ref="form" class="form inner" v-slot="{ errors }">
                <div class="inputDiv">
                    <label for="email">Email</label>
                    <Field class="form-control" name="email" autocomplete="username" type="email"
                        v-bind:class="{ 'is-invalid': errors.email }" />
                    <div v-if="errors.email" class="invalid-feedback">{{ errors.email }}
                    </div>
                </div>
                <div class="inputDiv">
                    <label for="password">Password</label>
                    <Field class="form-control" name="password" type="password" autocomplete="current-password"
                        v-bind:class="{ 'is-invalid': errors.password }" />
                    <div v-if="errors.password" class="invalid-feedback">{{ errors.password }}</div>
                </div>
                <div class="buttonDiv">
                    <button class="submitButton" type="submit" v-bind:disabled="isSubmitting">
                        <span v-if="!isSubmitting">Login</span>
                        <span v-else>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        </span>
                    </button>
                </div>
            </Form>
        </div>
    </div>
</template>
<style>
.blackBox {
    background-color: purple;
    padding: 10px;
    max-width: 700px;
    width: 30%;
    min-width: 275px;
}

.error {
    color: red;
}

.flexBox {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.submitButton {
    width: 30%;
}

input {
    color: black;
}

.buttonDiv {
    margin-top: 10px;
    width: 100%;
    display: flex;
    justify-content: flex-end;
}

.inputDiv {
    display: flex;
    flex-direction: column;
    margin-top: 5px;
    margin-bottom: 5px;
    width: 100%;
}

.form {
    display: flex;
    flex-direction: column;
}

.is-invalid {
    animation: shake 0.3s linear 1;
}

.shake {
    animation: shake 0.3s linear 1;
}

.invalid-feedback {
    animation: shake 0.3s linear 1;
    display: block !important;
}

@keyframes shake {
    0% {
        transform: translateX(0);
    }

    25% {
        transform: translateX(-5px);
    }

    50% {
        transform: translateX(0);
    }

    75% {
        transform: translateX(5px);
    }

    100% {
        transform: translateX(0);
    }
}
</style>
<script>
import { Form, Field } from 'vee-validate';

import axios from '../../axios.js'
import store from '../../store.js'
import * as Yup from 'yup';

export default {
    name: 'Login',
    components: {
        Form,
        Field,
    },
    data() {
        const schema = Yup.object().shape({
            email: Yup.string().required().email(),
            password: Yup.string().required(),
        });
        return {
            errorMessage: '',
            schema,
            isSubmitting: false,
        };
    },
    methods: {
        async login(values) {
            this.errorMessage = '';
            this.isSubmitting = true;
            try {
                await this.schema.validate(values, { abortEarly: false });
                if (this.$refs.form.validate()) {
                    const response = await axios.post('login', values);
                    switch (response.status) {
                        case 200:
                            store.commit('putIdUser', response.data.idUser);
                            store.commit('putApiKey', response.data.token);
                            this.$router.push('/dashboard');
                            break;
                        default:
                            console.log("onbekende success");
                            console.log(response);
                            break;
                    }
                }
            } catch (error) {
                if (error instanceof Yup.ValidationError) {
                    const errors = {};
                    error.inner.forEach((err) => {
                        errors[err.path] = [err.message];
                    });
                    this.$refs.form.setErrors(errors);
                } else {
                    switch (error.response.status) {
                        case 422:
                            this.errorMessage = "foute data parameters gegeven";
                            break;
                        case 401:
                            this.errorMessage = "email of wachtwoord komt niet overeen";
                            break;
                        case 409:
                            const errors = {};
                            for (const key in error.response.data.error) {
                                if (error.response.data.error.hasOwnProperty(key)) {
                                    errors[key] = [error.response.data.error[key][0]];
                                }
                            }
                            this.$refs.form.setErrors(errors);
                            break;
                        default:
                            this.errorMessage = "onbekende error";
                            console.log(error);
                            break;
                    }
                }
            } finally {
                this.isSubmitting = false;
            }
        }
    }
}

</script>