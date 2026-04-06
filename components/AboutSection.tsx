"use client";

import Image from "next/image";

export default function AboutSection() {
  return (
    <section className="about-section">
      <div className="about-inner">
        {/* Bottom-left blob image */}
        <div className="about-image about-image--left">
          <Image
            src="/front/assets/images/about_left.webp"
            alt="Goodiset Swedish Candy storefront"
            width={200}
            height={171}
          />
        </div>

        {/* Top-right blob image */}
        <div className="about-image about-image--right">
          <Image
            src="/front/assets/images/about_right.webp"
            alt="Goodiset Swedish Candy interior"
            width={200}
            height={171}
          />
        </div>

        {/* Center text */}
        <div className="about-content section">
          <h2 className="section_heading red center">
            Welcome to <span style={{ color: '#c1002e' }}>Goodiset</span>
          </h2>

          <p className="about-body">
            At Goodiset, we bring the authentic taste of Scandinavian sweets right to your doorstep. 
            Our carefully curated selection of Swedish candies, chocolates, and treats offers a 
            unique taste experience that you won&apos;t find anywhere else.
          </p>

          <p className="about-body about-body--highlight">
            From the famous Swedish pick and mix tradition to premium chocolate bars and 
            beautifully packaged gift boxes, every product is selected for its quality and 
            authentic Scandinavian heritage.
          </p>
        </div>
      </div>

      <style jsx>{`
        .about-section {
          background-color: #ffffff;
          position: relative;
          overflow: hidden;
          padding: 80px 16px;
        }
        .about-inner {
          max-width: 1290px;
          margin: 0 auto;
          position: relative;
          display: flex;
          flex-direction: column;
          align-items: center;
          gap: 20px;
        }
        .about-content {
          max-width: 700px;
          margin: 0 auto;
          text-align: center;
          position: relative;
          z-index: 2;
          padding: 0;
        }
        .section_heading {
          font-family: "Caprasimo", serif;
          font-size: clamp(32px, 3.6vw, 44px);
          font-weight: 400;
          line-height: 1.1;
          margin-bottom: 28px;
        }
        .section_heading.center {
          text-align: center;
        }
        .section_heading.red {
          color: #c1002e;
        }
        .about-body {
          margin: 0 auto 12px;
          max-width: 700px;
          font-size: clamp(15px, 1.3vw, 18px);
          line-height: 1.7;
          color: #555555;
        }
        .about-body--highlight {
          margin-top: 22px;
          font-weight: 600;
        }
        .about-image {
          z-index: 1;
          pointer-events: none;
        }
        .about-image--left {
          order: 1;
        }
        .about-image--right {
          order: 3;
        }
        .about-content {
          order: 2;
        }
        @keyframes aboutFloat {
          0%, 100% {
            transform: translateY(0);
          }
          50% {
            transform: translateY(-10px);
          }
        }
        @media (min-width: 1200px) {
          .about-inner {
            display: block;
            position: relative;
          }
          .about-image {
            position: absolute;
          }
          .about-image--left {
            bottom: 40px;
            left: 24px;
          }
          .about-image--right {
            top: 40px;
            right: 24px;
          }
          .about-content {
            padding: 0;
          }
        }
        @media (max-width: 480px) {
          .about-section {
            padding: 44px 14px;
          }
          .section_heading {
            font-size: 24px;
          }
        }
      `}</style>
    </section>
  );
}
