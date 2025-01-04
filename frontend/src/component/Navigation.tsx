'use client'

import Link from "next/link";
import styles from "./Navigation.module.css";
import React from "react";
const Navigation: React.FC = () => {
    return (
        <nav className={styles.nav}>
            <ul className={styles.navList}>
                <li>
                    <Link href="/">Home</Link>
                </li>
                <li>
                    <Link href="/signin">Sign In</Link>
                </li>
                <li>
                    <Link href="/signup">Sign Up</Link>
                </li>
            </ul>
        </nav>
    );
};

export default Navigation;
