"use client";

import Link from "next/link";

const flavours = [
  { name: "Sour", color: "#4ADE80", slug: "sour" },
  { name: "Sweet", color: "#F778E0", slug: "sweet" },
  { name: "Fruity", color: "#FB923C", slug: "fruity" },
  { name: "Chocolate", color: "#8B5A2B", slug: "chocolate" },
  { name: "Licorice", color: "#1F2937", slug: "licorice" },
  { name: "Salty", color: "#60A5FA", slug: "salty" },
  { name: "Fizzy", color: "#FACC15", slug: "fizzy" },
  { name: "Creamy", color: "#FBBF24", slug: "creamy" },
];

export default function FlavoursSection() {
  return (
    <section className="flavour-section section n_p_b n_p_t">
      <div className="flavour-inner">
        <div className="flavour-heading">
          <h2 className="section_heading red left">
            Explore by <span style={{ color: '#c1002e' }}>Flavour</span>
          </h2>
        </div>

        <div className="flavour-blobs">
          {flavours.map((flavour) => (
            <Link
              key={flavour.slug}
              href={`/shop?flavour=${flavour.slug}`}
              className="flavour-blob"
              style={{ '--blob-color': flavour.color } as React.CSSProperties}
            >
              <span className="flavour-blob__label">{flavour.name}</span>
            </Link>
          ))}
        </div>
      </div>

      <style jsx>{`
        .flavour-section {
          background-color: #ffffff;
        }
        .flavour-inner {
          padding: 60px 15px;
          max-width: 1290px;
          margin: 0 auto;
          display: flex;
          align-items: center;
          justify-content: space-between;
          gap: 40px;
          border-top: 1px solid #eeeeee;
        }
        .flavour-heading {
          flex: 0 0 auto;
        }
        .section_heading {
          font-family: "Caprasimo", serif;
          font-size: 36px;
          font-weight: 400;
          line-height: 1.2;
          margin: 0;
        }
        .section_heading.red {
          color: #c1002e;
        }
        .section_heading.left {
          text-align: left;
        }
        .flavour-blobs {
          flex: 1;
          display: flex;
          flex-wrap: wrap;
          gap: 24px;
          justify-content: flex-start;
        }
        .flavour-blob {
          --blob-color: #f778e0;
          position: relative;
          width: 150px;
          height: 94px;
          border: none;
          background: transparent;
          cursor: pointer;
          padding: 0;
          display: inline-flex;
          align-items: center;
          justify-content: center;
          font: inherit;
          text-decoration: none;
        }
        .flavour-blob::before {
          content: "";
          position: absolute;
          inset: 0;
          background-color: var(--blob-color);
          -webkit-mask-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='166' height='94' viewBox='0 0 166 94'%3E%3Cpath fill='white' d='M165.601 37.7611C163.201 -0.23888 111.601 -2.40555 86.101 1.26112C56.7676 4.92782 -4.67365 23.2994 0.282959 57.5C5.28296 92 72.101 95.2612 99.601 92.7612C122.601 90.2612 168.001 75.7611 165.601 37.7611Z'/%3E%3C/svg%3E");
          mask-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='166' height='94' viewBox='0 0 166 94'%3E%3Cpath fill='white' d='M165.601 37.7611C163.201 -0.23888 111.601 -2.40555 86.101 1.26112C56.7676 4.92782 -4.67365 23.2994 0.282959 57.5C5.28296 92 72.101 95.2612 99.601 92.7612C122.601 90.2612 168.001 75.7611 165.601 37.7611Z'/%3E%3C/svg%3E");
          -webkit-mask-repeat: no-repeat;
          mask-repeat: no-repeat;
          -webkit-mask-size: 100% 100%;
          mask-size: 100% 100%;
          transition: filter 0.2s ease;
        }
        .flavour-blob:hover::before {
          filter: brightness(0.9);
        }
        .flavour-blob__label {
          position: relative;
          z-index: 1;
          font-weight: 700;
          font-size: 16px;
          color: #111111;
          white-space: nowrap;
        }
        @media (max-width: 1200px) {
          .flavour-inner {
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 24px;
          }
          .section_heading.left {
            text-align: center;
          }
          .flavour-blobs {
            justify-content: center;
            gap: 16px;
          }
        }
        @media (max-width: 600px) {
          .flavour-inner {
            padding: 40px 16px;
          }
          .flavour-blob {
            transform: scale(0.9);
          }
          .section_heading {
            font-size: 24px;
          }
        }
      `}</style>
    </section>
  );
}
