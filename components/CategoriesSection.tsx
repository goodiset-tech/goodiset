"use client";

import Link from "next/link";
import Image from "next/image";

const categories = [
  {
    name: "Pick & Mix",
    slug: "pick-mix",
    subTitle: "Create your perfect candy mix from our wide selection",
    color: "#E1EAB4",
    image: "/img/category/pickmix.webp",
  },
  {
    name: "Pre-Mixed Bags",
    slug: "pre-mixed",
    subTitle: "Ready-to-enjoy candy selections curated for you",
    color: "#FFD4D4",
    image: "/img/category/premixed.webp",
  },
  {
    name: "Chocolates",
    slug: "chocolates",
    subTitle: "Premium Swedish chocolate delights",
    color: "#D4E4FF",
    image: "/img/category/chocolates.webp",
  },
  {
    name: "Gift Boxes",
    slug: "gift-boxes",
    subTitle: "Perfect treats for any special occasion",
    color: "#FFE4D4",
    image: "/img/category/giftbox.webp",
  },
];

export default function CategoriesSection() {
  return (
    <section className="section category">
      <div className="container">
        <h1 className="section_heading center red">Shop by Category</h1>
        <div className="row" style={{ justifyContent: 'center' }}>
          {categories.map((category) => (
            <div key={category.slug} className="col-xl-3 col-lg-4 col-md-6 col-6">
              <div 
                className="product-card" 
                aria-label={category.name}
                style={{ backgroundColor: category.color }}
              >
                <Link 
                  href={`/category/${category.slug}`} 
                  className="product-card__link"
                  title={category.name}
                />

                {/* Default state */}
                <div className="card-default">
                  <div className="card-circle" />
                </div>

                {/* Hover hero image */}
                <div className="card-hero">
                  <Image
                    src={category.image}
                    alt={category.name}
                    width={300}
                    height={220}
                    style={{ width: '100%', height: '100%', objectFit: 'cover' }}
                  />
                </div>

                {/* Wave + background mask */}
                <div className="card-mask" style={{ backgroundColor: category.color }}>
                  <svg 
                    width="376" 
                    height="12" 
                    viewBox="0 0 376 12" 
                    xmlns="http://www.w3.org/2000/svg"
                    preserveAspectRatio="none"
                  >
                    <path 
                      fill={category.color}
                      d="M219.033 3.95355C222.099 4.65027 224.994 5.40211 227.865 6.14792C233.676 7.65728 239.392 9.14197 246.24 10.095L246.661 10.1535C249.164 10.5019 251.318 10.8018 253.286 11.049C255.489 11.302 257.673 11.5109 259.607 11.6221C262.131 11.7672 264.303 11.8489 266.279 11.8708C268.255 11.8489 270.426 11.7672 272.951 11.6221C274.884 11.5109 277.069 11.302 279.271 11.049C281.239 10.8018 283.393 10.502 285.897 10.1535L286.317 10.095C293.165 9.14196 298.881 7.6573 304.692 6.14792C309.498 4.89965 314.369 3.63447 319.999 2.63913C321.221 2.4231 322.328 2.21903 323.37 2.02698C327.223 1.31684 330.184 0.771128 334.758 0.393406C341.735 -0.182772 345.7 -0.0768297 352.685 0.393404C358.015 0.752197 360.995 1.15517 366.267 2.01033C370.038 2.62201 373.088 3.33458 376 4.09809L375.984 12H0L0.0155877 4.15385C2.92768 3.39034 6.10812 2.62201 9.87909 2.01033C15.1511 1.15517 18.1309 0.752197 23.4606 0.393404C30.4457 -0.0768297 34.4112 -0.182772 41.3882 0.393406C45.9622 0.771129 48.9229 1.31684 52.7757 2.02698L52.777 2.02721C53.8185 2.21918 54.9254 2.4232 56.1468 2.63913C61.7771 3.63447 66.648 4.89965 71.4539 6.14792C77.265 7.65728 82.9811 9.14197 89.8291 10.095L90.2493 10.1535C92.7525 10.5019 94.9072 10.8018 96.8751 11.049C99.0776 11.302 101.262 11.5109 103.195 11.6221C105.72 11.7672 107.891 11.8489 109.867 11.8708C111.843 11.8489 114.015 11.7672 116.539 11.6221C118.473 11.5109 120.657 11.302 122.86 11.049C124.828 10.8018 126.982 10.502 129.485 10.1535L129.906 10.095C136.754 9.14196 142.47 7.6573 148.281 6.14792C151.152 5.40207 154.047 4.65018 157.113 3.95342C159.859 3.24459 162.759 2.58321 166.29 2.01033C168.377 1.67192 170.104 1.40434 171.76 1.18227C173.743 0.867395 175.794 0.604233 178.347 0.393406C182.16 0.0784708 185.074 -0.0326684 188.073 0.00808053C191.072 -0.0326684 193.986 0.0784708 197.8 0.393406C200.352 0.604226 202.403 0.867367 204.386 1.18223C206.042 1.4043 207.769 1.67191 209.856 2.01033C213.388 2.58325 216.287 3.24467 219.033 3.95355Z"
                    />
                  </svg>
                </div>

                {/* Content */}
                <div className="card-content">
                  <h2 className="card-subtitle">{category.name}</h2>
                  <p className="card-text">{category.subTitle}</p>
                  <Link 
                    className="card-btn" 
                    href={`/category/${category.slug}`}
                    title={category.name}
                  >
                    Shop Now
                  </Link>
                </div>
              </div>
            </div>
          ))}
        </div>
      </div>

      <style jsx>{`
        .section.category {
          padding: 80px 0;
          background: #fff;
        }
        .section_heading {
          font-family: "Caprasimo", serif;
          font-size: 36px;
          font-weight: 400;
          line-height: 1.2;
          margin-bottom: 40px;
        }
        .section_heading.center {
          text-align: center;
        }
        .section_heading.red {
          color: #c1002e;
        }
        .row {
          display: flex;
          flex-wrap: wrap;
          margin: 0 -15px;
        }
        .col-xl-3, .col-lg-4, .col-md-6, .col-6 {
          padding: 0 15px;
          width: 25%;
        }
        @media (max-width: 1200px) {
          .col-xl-3 { width: 33.333%; }
        }
        @media (max-width: 992px) {
          .col-lg-4, .col-xl-3 { width: 50%; }
        }
        @media (max-width: 768px) {
          .section.category { padding: 40px 0; }
          .section_heading { font-size: 24px; margin-bottom: 24px; }
          .col-md-6, .col-lg-4, .col-xl-3, .col-6 { width: 50%; }
        }
        .product-card {
          position: relative;
          width: 100%;
          height: 420px;
          margin: 0 auto;
          border-radius: 12px;
          overflow: hidden;
          box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
          cursor: pointer;
          margin-bottom: 30px;
          transition: transform 0.4s cubic-bezier(0.165, 0.84, 0.44, 1), box-shadow 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }
        .product-card:hover {
          transform: translateY(-8px);
          box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        .product-card__link {
          position: absolute;
          inset: 0;
          z-index: 0;
        }
        .card-default {
          position: absolute;
          inset: 0;
          z-index: 2;
          display: flex;
          flex-direction: column;
          align-items: center;
          justify-content: center;
          gap: 32px;
          opacity: 0;
          transition: opacity 0.3s ease;
        }
        .card-hero {
          position: absolute;
          top: 0;
          left: 0;
          right: 0;
          height: 220px;
          opacity: 1;
          z-index: 1;
          transition: opacity 0.3s ease 0.2s;
          overflow: hidden;
        }
        .product-card:hover .card-hero img {
          transform: scale(1.1);
        }
        .card-mask {
          position: absolute;
          left: 0;
          width: 100%;
          height: 420px;
          top: 220px;
          z-index: 2;
          transition: top 0.5s ease;
        }
        .card-mask svg {
          width: 100%;
          height: 12px;
          display: block;
          margin-top: -12px;
        }
        .card-content {
          position: absolute;
          left: 0;
          right: 0;
          top: 220px;
          height: calc(420px - 220px);
          padding: 24px 18px 22px;
          display: flex;
          flex-direction: column;
          text-align: center;
          z-index: 3;
          opacity: 1;
          transform: translateY(0);
          transition: opacity 0.35s ease 0.25s, transform 0.35s ease 0.25s;
        }
        .card-subtitle {
          font-size: 24px;
          font-weight: 900;
          color: #303030;
          margin-bottom: 8px;
        }
        .card-text {
          font-size: 13px;
          color: #000;
          margin-bottom: 24px;
        }
        .card-btn {
          display: inline-block;
          height: 40px;
          margin: 0 auto;
          width: 120px;
          border-radius: 999px;
          background: #ffffff;
          color: #303030;
          font-size: 14px;
          line-height: 40px;
          font-weight: 700;
          cursor: pointer;
          box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
          transition: background 0.2s ease, color 0.2s ease, transform 0.15s ease;
          position: relative;
          z-index: 4;
          text-decoration: none;
        }
        .card-btn:hover {
          background: #e92827;
          color: #ffffff;
        }
        @media (max-width: 575px) {
          .product-card { height: 320px; }
          .card-hero { height: 140px; }
          .card-mask { top: 140px; }
          .card-content { top: 140px; padding: 18px; }
          .card-subtitle { font-size: 15px; }
        }
      `}</style>
    </section>
  );
}
