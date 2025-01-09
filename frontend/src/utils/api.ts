import axios from 'axios';

const api = axios.create({
    baseURL: 'https://localhost:8080',
    headers: {
        'Content-Type': 'application/json',
    },
});

// Define types for request and response
export interface SignUpData {
    email: string;
    password: string;
}

export interface SignInData {
    email: string;
    password: string;
}

export interface ResetPasswordData {
    email: string;
}

export interface NewsletterData {
    email: string;
}


export const signUp = (data: SignUpData) => api.post('/api/register', data);
export const signIn = (data: SignInData) => api.post('/api/login', data);
export const resetPassword = (data: ResetPasswordData) => api.post('/api/reset-password', data);
export const newsletter = (data: NewsletterData) => api.post('/api/newsletter', data);
