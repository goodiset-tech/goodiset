import type { Metadata } from "next";
import "./globals.css";

export const metadata: Metadata = {
  title: "Goodiset - Swedish Candy Store",
  description: "Premium Swedish candy and sweets. Discover authentic Scandinavian treats delivered to your door.",
};

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  return (
    <html lang="en">
      <body>
        {children}
      </body>
    </html>
  );
}
