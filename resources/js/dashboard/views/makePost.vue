<template>
    <div class="flexBox">
        <div class="blackBox">
            <h1 class="h1Header">insert Post</h1>
            <div v-if="errorMessage" class="invalid-feedback">
                {{ errorMessage }}
            </div>
            <Form @submit="addPost" ref="form" class="form inner" v-slot="{ errors }">
                <div class="inputDiv">
                    <label for="title">Title</label>
                    <Field class="form-control" name="title" type="text" v-bind:class="{ 'is-invalid': errors.title }" />
                    <div v-if="errors.title" class="invalid-feedback">{{ errors.title }}
                    </div>
                </div>
                <div class="inputDiv">
                    <label for="content">Content</label>
                    <Field class="form-control" name="content" type="text"
                        v-bind:class="{ 'is-invalid': errors.content }" />
                    <div v-if="errors.content" class="invalid-feedback">{{ errors.content }}</div>
                </div>
                <div class="buttonDiv">
                    <button class="submitButton" type="submit" v-bind:disabled="isSubmitting">
                        <span v-if="!isSubmitting">Post</span>
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
            title: Yup.string().required(),
            content: Yup.string().required(),
        });
        return {
            errorMessage: '',
            schema,
            isSubmitting: false,
        };
    },
    methods: {
        async addPost(values) {
            this.errorMessage = '';
            this.isSubmitting = true;
            try {
                await this.schema.validate(values, { abortEarly: false });
                if (this.$refs.form.validate()) {
                    const response = await axios.post('store.post', values, {
                        headers: {
                            Authorization: `Bearer ${sessionStorage.getItem('API_KEY')}`
                        }
                    })
                    switch (response.status) {
                        case 200:
                            console.log("toegevoegd");
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
                    console.log(error);
                    switch (error.response.status) {
                        case 422:
                            this.errorMessage = "wrong parameters for api call";
                            break;
                        case 401:
                            this.errorMessage = "no acces to the api";
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