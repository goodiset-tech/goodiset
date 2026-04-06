"use client";

import Image from "next/image";
import Link from "next/link";

export default function HeroSection() {
  return (
    <section className="hero_section confetti-section">
      <div className="confetti-layer"></div>
      
      <div className="hero_slider">
        <div className="container">
          <Link href="/shop" title="hero_slider">
            <div className="hero_slide">
              <Image
                src="/img/slider/1750932777.webp"
                alt="Goodiset Swedish Candy Banner"
                width={1260}
                height={500}
                priority
                style={{ 
                  width: '100%', 
                  height: 'auto',
                  borderRadius: '24px'
                }}
              />
            </div>
          </Link>
        </div>
      </div>

      {/* Promotional Banners */}
      <section className="promo_banner">
        <div className="container">
          <div className="banner_grid">
            <div className="banner_item">
              <Link href="/category/pick-mix">
                <Image
                  src="/img/promotional/banner1.webp"
                  alt="Pick & Mix Promotion"
                  width={625}
                  height={200}
                  style={{ 
                    width: '100%', 
                    height: 'auto',
                    borderRadius: '12px'
                  }}
                />
              </Link>
            </div>
            <div className="banner_item">
              <Link href="/category/gift-boxes">
                <Image
                  src="/img/promotional/banner2.webp"
                  alt="Gift Boxes Promotion"
                  width={625}
                  height={200}
                  style={{ 
                    width: '100%', 
                    height: 'auto',
                    borderRadius: '12px'
                  }}
                />
              </Link>
            </div>
          </div>
        </div>
      </section>

      <style jsx>{`
        .hero_section {
          position: relative;
          width: 100%;
          overflow: hidden;
          background: none;
        }
        .confetti-layer {
          position: absolute;
          top: 0;
          left: 0;
          width: 100%;
          height: 450px;
          overflow: hidden;
          pointer-events: none;
          z-index: 1;
          opacity: 0.5;
        }
        .hero_slide {
          margin: 48px auto;
          position: relative;
          z-index: 2;
        }
        .promo_banner {
          padding: 0 0 40px;
        }
        .banner_grid {
          display: grid;
          grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
          gap: 30px;
          margin: 0 auto;
        }
        @media (max-width: 575px) {
          .hero_slide {
            margin: 24px auto 0 auto;
          }
          .banner_grid {
            grid-template-columns: 1fr;
            gap: 12px;
            margin-top: 12px;
          }
        }
      `}</style>
    </section>
  );
}
