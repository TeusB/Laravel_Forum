<template>
    <div class="table-container" v-if="post">
        <h1>Post</h1>
        {{ post.title }} by:
        {{ post.user?.name }}
        <img :src="imageUrl(post.user?.profileIMG)" alt="Admin" class="rounded-circle" width="150">
        <br>
        <br>
        {{ post.content }}
        <h2>Comments</h2>
        <div v-if="errorMessage || successMessage" class="displayTrue"
            v-bind:class="{ 'invalid-feedback': errorMessage, 'valid-feedback': successMessage }">
            {{ errorMessage }}
            {{ successMessage }}
        </div>
        <Form @submit="addComment" ref="form" class="form inner" v-slot="{ errors }">
            <div class="inputDiv">
                <label for="title">Title</label>
                <Field class="form-control" name="title" type="text" v-bind:class="{ 'is-invalid': errors.title }" />
                <div v-if="errors.title" class="invalid-feedback">{{ errors.title }}
                </div>
            </div>
            <div class="inputDiv">
                <label for="content">Content</label>
                <Field class="form-control" name="content" type="text" v-bind:class="{ 'is-invalid': errors.content }" />
                <div v-if="errors.content" class="invalid-feedback">{{ errors.content }}</div>
            </div>
            <div class="buttonDiv">
                <button class="submitButton" type="submit" v-bind:disabled="isSubmitting">
                    <span v-if="!isSubmitting">Comment</span>
                    <span v-else>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    </span>
                </button>
            </div>
        </Form>
        <ul>
            <li v-for="comment in post.comments?.slice()?.reverse()" :key="comment.id">
                <h3>{{ comment.title }}</h3>
                <p>{{ comment.content }}</p>
                <p>Commented by {{ comment.user?.name }}</p>
                <img :src="imageUrl(comment.user?.profileIMG)" alt="Admin" class="rounded-circle" width="150">
            </li>
        </ul>
    </div>
</template>
<script>
import { Form, Field } from 'vee-validate';
import * as Yup from 'yup';
import axios from '../../axios.js';

export default {
    data() {
        const schema = Yup.object().shape({
            title: Yup.string().required(),
            content: Yup.string().required(),
        });
        return {
            post: [],
            errorMessage: '',
            successMessage: '',
            schema,
            isSubmitting: false,
        };
    },
    components: {
        Form,
        Field,
    },
    methods: {
        imageUrl(profileIMG) {
            return `../../../../avatars/${profileIMG}`;
        },
        async addComment(values) {
            this.errorMessage = '';
            this.isSubmitting = true;
            try {
                await this.schema.validate(values, { abortEarly: false });
                if (this.$refs.form.validate()) {
                    const response = await axios.post('store.comment/' + this.$route.params.id, values, {
                        headers: {
                            Authorization: `Bearer ${sessionStorage.getItem('API_TOKEN')}`
                        }
                    })
                    switch (response.status) {
                        case 200:
                            this.successMessage = response.data.message;
                            let newComment = {
                                title: values.title,
                                content: values.content,
                                user: {
                                    name: this.$store.state.user.name,
                                    profileIMG: this.$store.state.user.profileIMG,
                                }
                            };
                            this.post.comments?.splice(this.post.comments.length, 0, newComment);

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
                        case 403:
                            this.errorMessage = "You are not allowed to do this";
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
    },
    created() {
        axios.get('post/' + this.$route.params.id, {
            headers: {
                Authorization: `Bearer ${sessionStorage.getItem('API_TOKEN')}`
            }
        })
            .then(response => {
                console.log(response);
                this.post = response.data.post;
            })
            .catch(error => {
                console.log(error);
            });
    }
};
</script>