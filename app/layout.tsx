import type { Metadata, Viewport } from "next";
import "./globals.css";
import "@/public/front/assets/sass/main.css";
import "@/public/front/assets/sass/bootstrap.min.css";

export const viewport: Viewport = {
  width: 'device-width',
  initialScale: 1,
}

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
    <html lang="en" dir="ltr">
      <head>
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossOrigin="anonymous" />
        <link 
          href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Caprasimo&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" 
          rel="stylesheet" 
        />
        <link 
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" 
          rel="stylesheet" 
        />
      </head>
      <body id="body" className="ltr">
        <div className="body-container">
          {children}
        </div>
      </body>
    </html>
  );
}
