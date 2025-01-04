"use client";

import React, { useState, ChangeEvent, FormEvent } from "react";
import { signIn, SignInData } from "@/utils/api";
import axios from "axios";

const SignIn: React.FC = () => {
    const [formData, setFormData] = useState<SignInData>({
        email: "",
        password: "",
    });

    const [message, setMessage] = useState<string>("");

    const handleChange = (e: ChangeEvent<HTMLInputElement>) => {
        const { name, value } = e.target;
        setFormData((prev) => ({ ...prev, [name]: value }));
    };

    const handleSubmit = async (e: FormEvent) => {
        e.preventDefault();
        try {
            const response = await signIn(formData);
            setMessage("Sign-in successful!");
            localStorage.setItem("token", response.data.token); // Store token
        } catch (error: unknown) {
            if (axios.isAxiosError(error)) {
                setMessage(error.response?.data?.message || "Error during sign-in.");
            } else {
                setMessage("Unexpected error occurred.");
            }
        }
    };

    return (
        <div>
            <h1>Sign In</h1>
            <form onSubmit={handleSubmit}>
                <input
                    type="email"
                    name="email"
                    placeholder="Email"
                    value={formData.email}
                    onChange={handleChange}
                    required
                />
                <input
                    type="password"
                    name="password"
                    placeholder="Password"
                    value={formData.password}
                    onChange={handleChange}
                    required
                />
                <button type="submit">Sign In</button>
            </form>
            {message && <p>{message}</p>}
        </div>
    );
};

export default SignIn;
