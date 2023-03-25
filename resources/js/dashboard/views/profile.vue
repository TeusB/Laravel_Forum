<template>
    <div class="d-row gutters-sm" v-if="user">
        <div class="d-row flex">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-column align-items-center text-center">
                        <img :src="imageUrl" alt="Admin" class="rounded-circle" width="150">
                        <div class="mt-3">
                            <h4>{{ user.name }}</h4>
                            <p class="text-secondary mb-1">Senior Full Stack Developer</p>
                            <p class="text-muted font-size-sm">Bay Area, San Francisco, CA</p>
                            <div v-if="errorMessageIMG || successMessageIMG" class="displayTrue"
                                v-bind:class="{ 'invalid-feedback': errorMessageIMG, 'valid-feedback': successMessageIMG }">
                                {{ errorMessageIMG }}
                                {{ successMessageIMG }}
                            </div>
                            <Form @submit="updateIMG" ref="formIMG" class="form inner" v-slot="{ errors }">
                                <Field :accept="'image/*'" type="file" name="profileIMG" />
                                <div v-if="errors.profileIMG" class="invalid-feedback">{{ errors.profileIMG }}
                                </div>
                                <button class="submitButton" type="submit" v-bind:disabled="isSubmittingIMG">
                                    <span v-if="!isSubmittingIMG">change</span>
                                    <span v-else>
                                        <span class="spinner-border spinner-border-sm" role="status"
                                            aria-hidden="true"></span>
                                    </span>
                                </button>
                            </Form>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="col-md-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <div v-if="errorMessage || successMessage" class="displayTrue"
                            v-bind:class="{ 'invalid-feedback': errorMessage, 'valid-feedback': successMessage }">
                            {{ errorMessage }}
                            {{ successMessage }}
                        </div>
                        <Form @submit="updateUser" ref="form" class="form inner" v-slot="{ errors }">
                            <div class="inputDiv">
                                <label for="name">Name</label>
                                <Field class="form-control" name="name" type="text"
                                    v-bind:class="{ 'is-invalid': errors.name }" v-model="userForm.name" />
                                <div v-if="errors.name" class="invalid-feedback">{{ errors.name }}
                                </div>
                            </div>
                            <hr>
                            <div class="inputDiv">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Email</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ user.email }}
                                </div>
                            </div>
                            <div class="buttonDiv">
                                <button class="submitButton" type="submit" v-bind:disabled="isSubmitting">
                                    <span v-if="!isSubmitting">change</span>
                                    <span v-else>
                                        <span class="spinner-border spinner-border-sm" role="status"
                                            aria-hidden="true"></span>
                                    </span>
                                </button>
                            </div>
                        </Form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
import { Form, Field } from 'vee-validate';
import { mapState } from 'vuex';

import axios from '../../axios.js'
import store from '../../store.js'
import * as Yup from 'yup';

export default {
    name: 'updateUser',
    components: {
        Form,
        Field,
    },
    data() {
        const schema = Yup.object().shape({
            name: Yup.string().required(),
        });
        const schemaIMG = Yup.object().shape({
            profileIMG: Yup.mixed().required('Image is required').test('fileSize', 'Image size must be less than 5MB', value =>
                value ? value.size <= 5242880 : true
            )
        });
        return {
            userForm: [],
            errorMessage: '',
            successMessage: '',
            errorMessageIMG: '',
            successMessageIMG: '',
            schema,
            schemaIMG,
            isSubmitting: false,
            isSubmittingIMG: false,
        };
    },
    created() {
        axios.get('user', {
            headers: {
                Authorization: `Bearer ${sessionStorage.getItem('API_KEY')}`
            }
        })
            .then(response => {
                this.userForm = response.data.user;
            })
            .catch(error => {
                console.log(error);
            });
    },
    computed: {
        ...mapState({
            user: state => state.user,
        }),
        imageUrl() {
            return `../../../../avatars/${this.$store.state.user.profileIMG}`;
        }
    },
    methods: {
        async updateUser(values) {
            this.errorMessage = '';
            this.successMessage = '';
            this.isSubmitting = true;
            try {
                await this.schema.validate(values, { abortEarly: false });
                if (this.$refs.form.validate()) {
                    const response = await axios.post('update.user', values, {
                        headers: {
                            Authorization: `Bearer ${sessionStorage.getItem('API_KEY')}`
                        }
                    })
                    switch (response.status) {
                        case 200:
                            this.successMessage = response.data.success;
                            store.commit('updateUserProperty', { name: values.name });
                            break;
                        default:
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
        },
        async updateIMG(values) {
            this.errorMessageIMG = '';
            this.successMessageIMG = '';
            this.isSubmittingIMG = true;
            try {
                await this.schemaIMG.validate(values, { abortEarly: false });
                if (this.$refs.formIMG.validate()) {
                    const response = await axios.post('update.profileIMG', values, {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                            Authorization: `Bearer ${sessionStorage.getItem('API_KEY')}`
                        }
                    })
                    switch (response.status) {
                        case 200:
                            store.commit('updateUserProperty', { profileIMG: response.data.profileIMG });
                            this.successMessageIMG = response.data.messsage;
                            break;
                        default:
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
                    this.$refs.formIMG.setErrors(errors);
                } else {
                    console.log(error);
                    switch (error.response.status) {
                        case 422:
                            this.errorMessageIMG = "wrong parameters for api call";
                            break;
                        case 401:
                            this.errorMessageIMG = "no acces to the api";
                            break;
                        case 409:
                            const errors = {};
                            for (const key in error.response.data.error) {
                                if (error.response.data.error.hasOwnProperty(key)) {
                                    errors[key] = [error.response.data.error[key][0]];
                                }
                            }
                            this.$refs.formIMG.setErrors(errors);
                            break;
                        default:
                            this.errorMessageIMG = "onbekende error";
                            console.log(error);
                            break;
                    }
                }
            } finally {
                this.isSubmittingIMG = false;
            }
        }
    }
};
</script>