"use client";

import Link from "next/link";
import Image from "next/image";

export default function Footer() {
  return (
    <footer className="footer">
      <div className="container">
        <div className="footer-grid">
          {/* Logo & Description */}
          <div className="footer-col footer-about">
            <Image
              src="/front/assets/images/logo.png"
              alt="Goodiset"
              width={165}
              height={72}
              className="footer-logo"
            />
            <p className="footer-desc">
              Premium Swedish candy and sweets. Discover authentic Scandinavian treats delivered to your door in the UAE.
            </p>
            <div className="social-links">
              <a
                href="https://www.facebook.com/share/1CkAwUTTgm/"
                target="_blank"
                rel="noopener noreferrer"
                aria-label="Facebook"
              >
                <i className="fa-brands fa-facebook-f"></i>
              </a>
              <a
                href="https://www.tiktok.com/@goodiset"
                target="_blank"
                rel="noopener noreferrer"
                aria-label="TikTok"
              >
                <i className="fa-brands fa-tiktok"></i>
              </a>
              <a
                href="https://www.instagram.com/goodiset"
                target="_blank"
                rel="noopener noreferrer"
                aria-label="Instagram"
              >
                <i className="fa-brands fa-instagram"></i>
              </a>
            </div>
          </div>

          {/* Company Links */}
          <div className="footer-col">
            <h3 className="footer-heading">Company</h3>
            <ul className="footer-links">
              <li><Link href="/about">About Us</Link></li>
              <li><Link href="/blogs">Blog</Link></li>
              <li><Link href="/login">Join Us</Link></li>
              <li><Link href="/contact">Contact Us</Link></li>
            </ul>
          </div>

          {/* Help Links */}
          <div className="footer-col">
            <h3 className="footer-heading">Help</h3>
            <ul className="footer-links">
              <li><Link href="/terms">Terms & Conditions</Link></li>
              <li><Link href="/faqs">FAQs</Link></li>
              <li><Link href="/privacy">Privacy Policy</Link></li>
              <li><Link href="/corporate-events">Corporate Events</Link></li>
            </ul>
          </div>

          {/* Newsletter */}
          <div className="footer-col footer-newsletter">
            <h3 className="footer-heading">Newsletter</h3>
            <p className="newsletter-text">Subscribe to get special offers and updates!</p>
            <form className="newsletter-form">
              <input
                type="email"
                placeholder="Enter your email"
                className="newsletter-input"
              />
              <button type="submit" className="newsletter-btn">
                Subscribe
              </button>
            </form>
          </div>
        </div>

        {/* Bottom Bar */}
        <div className="footer-bottom">
          <p className="copyright">
            &copy; {new Date().getFullYear()} Goodiset. All rights reserved.
          </p>
          <div className="payment-icons">
            <span className="payment-icon">
              <i className="fa-brands fa-cc-visa"></i>
            </span>
            <span className="payment-icon">
              <i className="fa-brands fa-cc-mastercard"></i>
            </span>
            <span className="payment-icon">
              <i className="fa-brands fa-cc-apple-pay"></i>
            </span>
          </div>
        </div>
      </div>

      <style jsx>{`
        .footer {
          background: #1a1a1a;
          color: #fff;
          padding: 60px 0 30px;
        }
        .container {
          max-width: 1290px;
          margin: 0 auto;
          padding: 0 15px;
        }
        .footer-grid {
          display: grid;
          grid-template-columns: 1.5fr 1fr 1fr 1.5fr;
          gap: 40px;
        }
        .footer-logo {
          height: 48px;
          width: auto;
          margin-bottom: 16px;
          filter: brightness(0) invert(1);
        }
        .footer-desc {
          color: #9ca3af;
          font-size: 14px;
          line-height: 1.6;
          margin-bottom: 20px;
        }
        .social-links {
          display: flex;
          gap: 12px;
        }
        .social-links a {
          width: 36px;
          height: 36px;
          border-radius: 50%;
          background: #333;
          display: flex;
          align-items: center;
          justify-content: center;
          color: #fff;
          font-size: 16px;
          transition: all 0.2s;
        }
        .social-links a:hover {
          background: #e92827;
        }
        .footer-heading {
          font-size: 18px;
          font-weight: 600;
          margin-bottom: 20px;
          color: #fff;
        }
        .footer-links {
          list-style: none;
          padding: 0;
          margin: 0;
        }
        .footer-links li {
          margin-bottom: 12px;
        }
        .footer-links a {
          color: #9ca3af;
          font-size: 14px;
          transition: color 0.2s;
        }
        .footer-links a:hover {
          color: #fff;
        }
        .newsletter-text {
          color: #9ca3af;
          font-size: 14px;
          margin-bottom: 16px;
        }
        .newsletter-form {
          display: flex;
          flex-direction: column;
          gap: 12px;
        }
        .newsletter-input {
          padding: 12px 16px;
          border-radius: 8px;
          border: 1px solid #333;
          background: #262626;
          color: #fff;
          font-size: 14px;
          outline: none;
        }
        .newsletter-input::placeholder {
          color: #6b7280;
        }
        .newsletter-input:focus {
          border-color: #e92827;
        }
        .newsletter-btn {
          padding: 12px 24px;
          border-radius: 8px;
          border: none;
          background: #e92827;
          color: #fff;
          font-size: 14px;
          font-weight: 600;
          cursor: pointer;
          transition: background 0.2s;
        }
        .newsletter-btn:hover {
          background: #c1002e;
        }
        .footer-bottom {
          display: flex;
          justify-content: space-between;
          align-items: center;
          border-top: 1px solid #333;
          margin-top: 40px;
          padding-top: 24px;
        }
        .copyright {
          color: #6b7280;
          font-size: 14px;
          margin: 0;
        }
        .payment-icons {
          display: flex;
          gap: 16px;
        }
        .payment-icon {
          font-size: 28px;
          color: #6b7280;
        }
        @media (max-width: 992px) {
          .footer-grid {
            grid-template-columns: 1fr 1fr;
          }
        }
        @media (max-width: 576px) {
          .footer-grid {
            grid-template-columns: 1fr;
            gap: 30px;
          }
          .footer-bottom {
            flex-direction: column;
            gap: 16px;
            text-align: center;
          }
        }
      `}</style>
    </footer>
  );
}
