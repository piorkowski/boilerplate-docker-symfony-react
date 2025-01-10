"use client";

import React, { useState, ChangeEvent, FormEvent } from "react";
import { signUp, SignUpData } from "@/utils/api";
import axios from "axios";

const SignUp: React.FC = () => {
    const [formData, setFormData] = useState<SignUpData & { confirmPassword: string }>({
        email: "",
        password: "",
        confirmPassword: "",
    });

    const [message, setMessage] = useState<string>("");

    const handleChange = (e: ChangeEvent<HTMLInputElement>) => {
        const { name, value } = e.target;
        setFormData((prev) => ({ ...prev, [name]: value }));
    };

    const handleSubmit = async (e: FormEvent) => {
        e.preventDefault();
        if (formData.password !== formData.confirmPassword) {
            setMessage("Passwords do not match.");
            return;
        }

        try {
            await signUp({ email: formData.email, password: formData.password });
            setMessage("Registration successful! Please sign in.");
        } catch (error: unknown) {
            if (axios.isAxiosError(error)) {
                setMessage(error.response?.data?.message || "Error during sign-up.");
            } else {
                setMessage("Unexpected error occurred.");
            }
        }
    };

    return (
        <div>
            <h1>Sign Up</h1>
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
                <input
                    type="password"
                    name="confirmPassword"
                    placeholder="Confirm Password"
                    value={formData.confirmPassword}
                    onChange={handleChange}
                    required
                />
                <button type="submit">Sign Up</button>
            </form>
            {message && <p>{message}</p>}
        </div>
    );
};

export default SignUp;
