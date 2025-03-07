import { Outlet } from "react-router-dom";
import Header from "./Header";
import Navbar from "./Navbar";

export default function Layout() {
    return (
        <div className="min-h-screen flex flex-col">
            <Header />
            <Navbar />
            <main className="flex-grow p-4">
                <Outlet />
            </main>
        </div>
    );
}
